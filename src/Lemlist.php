<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist;

use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Resource\ResourceAccessors;
use Psr\SimpleCache\CacheInterface;

/**
 * Client de l'API lemlist. Façade sans héritage Saloon : le transport est un
 * détail d'implémentation, remplaçable sans toucher au contrat public.
 */
final class Lemlist
{
    use ResourceAccessors;

    /**
     * Version du paquet, telle qu'annoncée dans le `User-Agent`.
     */
    public const string VERSION = '0.1.0';

    public const int DEFAULT_MAX_RETRIES = LemlistConnector::DEFAULT_MAX_RETRIES;

    private readonly LemlistConnector $connector;

    /**
     * `$apiKey` est marqué sensible : une trace conservant les arguments
     * afficherait la clé en clair.
     *
     * @param CacheInterface|null $rateLimitCache cache partagé pour le compteur de débit, à fournir dès que
     *                                            plusieurs process utilisent la même clé d'API
     * @param int                 $maxRetries     nouvelles tentatives sur un 429 ou un 5xx ; `0` les désactive
     */
    public function __construct(
        #[\SensitiveParameter] string $apiKey,
        ?CacheInterface $rateLimitCache = null,
        int $maxRetries = self::DEFAULT_MAX_RETRIES,
        ?float $requestTimeout = null,
        ?float $connectTimeout = null,
    ) {
        $this->connector = new LemlistConnector(
            $apiKey,
            $rateLimitCache,
            $maxRetries,
            $requestTimeout,
            $connectTimeout,
        );
    }

    /**
     * Accès au transport Saloon sous-jacent, hors contrat de compatibilité.
     *
     * @internal réservé à `Testing\` et aux tests du SDK
     */
    public function connector(): LemlistConnector
    {
        return $this->connector;
    }
}
