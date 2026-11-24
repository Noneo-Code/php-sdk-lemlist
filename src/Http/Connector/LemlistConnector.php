<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Http\Connector;

use Noneo\Sdk\Lemlist\Concerns\AppliesLemlistTimeouts;
use Noneo\Sdk\Lemlist\Concerns\HandlesLemlistErrors;
use Noneo\Sdk\Lemlist\Concerns\RespectsLemlistRateLimits;
use Noneo\Sdk\Lemlist\Concerns\SecuresLemlistTransport;
use Noneo\Sdk\Lemlist\Exception\ConnectionException;
use Psr\SimpleCache\CacheInterface;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Http\Auth\BasicAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Transport Saloon de l'API lemlist. Détail d'implémentation : rien ici
 * n'appartient au contrat public du SDK, qui s'arrête à la façade
 * {@see \Noneo\Sdk\Lemlist\Lemlist}.
 *
 * @internal
 */
final class LemlistConnector extends Connector
{
    use AppliesLemlistTimeouts;
    use HandlesLemlistErrors;
    use RespectsLemlistRateLimits;
    use SecuresLemlistTransport;

    public function __construct(
        #[\SensitiveParameter] string $apiKey,
        ?CacheInterface $rateLimitCache = null,
        int $maxRetries = self::DEFAULT_MAX_RETRIES,
        ?float $requestTimeout = null,
        ?float $connectTimeout = null,
    ) {
        // lemlist attend un login vide et la clé d'API en mot de passe.
        $this->authenticate(new BasicAuthenticator('', $apiKey));

        if ($rateLimitCache instanceof CacheInterface) {
            $this->useRateLimitStore(new PsrRateLimitStore($rateLimitCache));
        }

        $this->useMaxRetries($maxRetries);
        $this->useTimeouts($requestTimeout, $connectTimeout);
    }

    public function resolveBaseUrl(): string
    {
        return 'https://api.lemlist.com/api';
    }

    /**
     * Une panne réseau remonte de Saloon sous la forme d'une exception qui
     * retient la requête signée ; elle est traduite ici pour que le
     * consommateur ne reçoive que des `LemlistException`.
     */
    public function send(Request $request, ?MockClient $mockClient = null, ?callable $handleRetry = null): Response
    {
        try {
            return parent::send($request, $mockClient, $handleRetry);
        } catch (FatalRequestException $exception) {
            throw ConnectionException::fromMessage($exception->getMessage());
        }
    }
}
