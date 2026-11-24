<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Http\Connector;

use Psr\SimpleCache\CacheInterface;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;

/**
 * Compteur de débit adossé à un cache PSR-16.
 *
 * Le `PsrStore` du plugin Saloon écrit sous une clé de la forme
 * `lemlist:<clé hachée>:20_every_2`. Or la PSR-16 réserve le caractère `:`, et
 * une implémentation stricte — `Symfony\Component\Cache\Psr16Cache` en tête —
 * rejette une telle clé par une exception à la première requête. Les
 * caractères réservés sont donc remplacés avant tout accès au cache.
 *
 * @internal
 */
final readonly class PsrRateLimitStore implements RateLimitStore
{
    public function __construct(private CacheInterface $cache)
    {
    }

    public function get(string $key): ?string
    {
        $value = $this->cache->get(self::normalize($key));

        return is_string($value) ? $value : null;
    }

    public function set(string $key, string $value, int $ttl): bool
    {
        return $this->cache->set(self::normalize($key), $value, $ttl);
    }

    private static function normalize(string $key): string
    {
        return (string) preg_replace('/[^A-Za-z0-9_.]/', '.', $key);
    }
}
