<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Concerns;

use Saloon\Enums\Method;
use Saloon\Http\Auth\BasicAuthenticator;
use Saloon\Http\PendingRequest;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Helpers\RetryAfterHelper;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\MemoryStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;

/**
 * lemlist autorise 20 requêtes toutes les 2 secondes, par clé d'API — quota
 * partagé entre tous les process qui utilisent cette clé. `HasRateLimits`
 * bride notre propre débit sortant ; le rejeu d'un 429 ou d'un 5xx réellement
 * reçu est géré à part, ci-dessous, pour que l'attente suive le `Retry-After`
 * du serveur plutôt qu'un backoff aveugle.
 */
trait RespectsLemlistRateLimits
{
    use HasRateLimits;

    /**
     * Nombre de *nouvelles* tentatives après l'échec initial : `3` signifie
     * quatre appels HTTP au pire, `0` désactive tout rejeu.
     */
    public const int DEFAULT_MAX_RETRIES = 3;

    private const float BASE_RETRY_DELAY = 0.5;

    private const float MAX_RETRY_DELAY = 8.0;

    private const float RETRY_JITTER = 0.25;

    /**
     * Plafond appliqué à un `Retry-After` reçu du serveur : au-delà, mieux vaut
     * rendre la main à l'appelant que bloquer le process plusieurs minutes.
     */
    private const int MAX_RETRY_AFTER_DELAY = 60;

    /**
     * `PATCH` en est volontairement absent : la sémantique d'un patch partiel
     * (incrément, ajout à une liste) n'est pas idempotente en général.
     */
    private const array IDEMPOTENT_METHODS = [Method::GET, Method::HEAD, Method::PUT, Method::DELETE];

    private ?RateLimitStore $configuredRateLimitStore = null;

    private int $maxRetries = self::DEFAULT_MAX_RETRIES;

    /**
     * @var (\Closure(float): void)|null
     */
    private ?\Closure $sleeper = null;

    /**
     * Nombre de tentatives déjà consommées, par requête. Une `WeakMap` plutôt
     * qu'un tableau indexé sur `spl_object_id` : PHP recycle ces identifiants
     * dès qu'un objet est libéré, si bien qu'une nouvelle requête pourrait
     * hériter du compteur d'une requête morte.
     *
     * @var \WeakMap<Request, int>|null
     */
    private ?\WeakMap $retryAttempts = null;

    public function useRateLimitStore(RateLimitStore $store): static
    {
        $this->configuredRateLimitStore = $store;

        return $this;
    }

    public function useMaxRetries(int $maxRetries): static
    {
        $this->maxRetries = max(0, $maxRetries);

        return $this;
    }

    /**
     * Remplace l'attente réelle entre deux tentatives — pour les tests.
     *
     * @param \Closure(float): void $sleeper
     */
    public function useSleeper(\Closure $sleeper): static
    {
        $this->sleeper = $sleeper;

        return $this;
    }

    public function bootRespectsLemlistRateLimits(PendingRequest $pendingRequest): void
    {
        // Sans cela, le plugin lèverait sa propre exception sur un 429 au lieu
        // de laisser le rejeu ci-dessous s'en charger.
        $this->detectTooManyAttempts = false;

        $pendingRequest->middleware()->onResponse(function (Response $response): Response {
            if (!$this->isRetryableFailure($response)) {
                return $response;
            }

            $request = $response->getRequest();
            $attempts = $this->retryAttempts()[$request] ?? 0;

            if ($attempts >= $this->maxRetries) {
                unset($this->retryAttempts()[$request]);

                return $response;
            }

            $this->retryAttempts()[$request] = $attempts + 1;

            $this->wait($this->retryDelay($response, $attempts));

            $retried = $response->getConnector()->send($request);

            unset($this->retryAttempts()[$request]);

            return $retried;
        });
    }

    protected function resolveRateLimitStore(): RateLimitStore
    {
        return $this->configuredRateLimitStore ??= new MemoryStore();
    }

    /**
     * @return array<Limit>
     */
    protected function resolveLimits(): array
    {
        return [
            Limit::allow(20)->everySeconds(2)->sleep(),
        ];
    }

    /**
     * Le quota est décompté par clé d'API : deux clés partageant un même store
     * — le cache PSR recommandé dès qu'un process est répliqué — ne doivent pas
     * se disputer un unique compteur. La clé est hachée : elle n'a rien à faire
     * en clair dans une clé de cache.
     */
    protected function getLimiterPrefix(): ?string
    {
        $authenticator = $this->getAuthenticator();

        if (!$authenticator instanceof BasicAuthenticator) {
            return 'lemlist:shared';
        }

        return 'lemlist:'.substr(hash('xxh128', $authenticator->password), 0, 12);
    }

    /**
     * Combien attendre avant la tentative n° `$attempts + 1`.
     *
     * Le serveur a le dernier mot : un `Retry-After` exploitable est honoré tel
     * quel, simplement plafonné pour qu'un en-tête aberrant ne fige pas le
     * process. Sans en-tête — le cas courant des 5xx — on retombe sur un
     * backoff exponentiel.
     */
    private function retryDelay(Response $response, int $attempts): float
    {
        $header = $response->header('Retry-After');
        $retryAfter = RetryAfterHelper::parse(is_string($header) ? $header : null);

        if (null !== $retryAfter && $retryAfter > 0) {
            return (float) min($retryAfter, self::MAX_RETRY_AFTER_DELAY);
        }

        $delay = min(self::BASE_RETRY_DELAY * 2 ** $attempts, self::MAX_RETRY_DELAY);

        // Jitter soustractif : il désynchronise les rafales de plusieurs
        // process sans jamais franchir le plafond par le haut.
        return round($delay * (1.0 - self::RETRY_JITTER * random_int(0, 1000) / 1000), 3);
    }

    private function wait(float $seconds): void
    {
        if ($seconds <= 0) {
            return;
        }

        if ($this->sleeper instanceof \Closure) {
            ($this->sleeper)($seconds);

            return;
        }

        usleep((int) round($seconds * 1_000_000));
    }

    /**
     * @return \WeakMap<Request, int>
     */
    private function retryAttempts(): \WeakMap
    {
        return $this->retryAttempts ??= new \WeakMap();
    }

    /**
     * Un 429 dit que la requête n'a pas été traitée : la rejouer est sûr, quelle
     * que soit la méthode. Un 5xx, lui, ne dit rien — un 502 de proxy laisse
     * entière la question de savoir si lemlist a traité l'appel. On ne rejoue
     * alors que les méthodes qui supportent d'être répétées : rejouer un
     * `POST /campaigns/{id}/leads/` créerait un second lead.
     */
    private function isRetryableFailure(Response $response): bool
    {
        if (429 === $response->status()) {
            return true;
        }

        return $response->serverError()
            && in_array($response->getPendingRequest()->getMethod(), self::IDEMPOTENT_METHODS, true);
    }
}
