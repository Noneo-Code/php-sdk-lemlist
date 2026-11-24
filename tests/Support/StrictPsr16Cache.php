<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests\Support;

use Psr\SimpleCache\CacheInterface;

/**
 * Cache en mémoire aussi strict que la PSR-16 l'autorise — et que l'est
 * `Symfony\Component\Cache\Psr16Cache` : une clé ne peut contenir que
 * `A-Z`, `a-z`, `0-9`, `_` et `.`, sur 64 caractères au plus.
 */
final class StrictPsr16Cache implements CacheInterface
{
    /**
     * @var array<string, mixed>
     */
    public array $values = [];

    public function get(string $key, mixed $default = null): mixed
    {
        self::validate($key);

        return $this->values[$key] ?? $default;
    }

    public function set(string $key, mixed $value, \DateInterval|int|null $ttl = null): bool
    {
        self::validate($key);
        $this->values[$key] = $value;

        return true;
    }

    public function delete(string $key): bool
    {
        self::validate($key);
        unset($this->values[$key]);

        return true;
    }

    public function clear(): bool
    {
        $this->values = [];

        return true;
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $values = [];

        foreach ($keys as $key) {
            $values[$key] = $this->get($key, $default);
        }

        return $values;
    }

    /**
     * @param iterable<string, mixed> $values
     */
    public function setMultiple(iterable $values, \DateInterval|int|null $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }

        return true;
    }

    public function deleteMultiple(iterable $keys): bool
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }

        return true;
    }

    public function has(string $key): bool
    {
        self::validate($key);

        return isset($this->values[$key]);
    }

    private static function validate(string $key): void
    {
        if (1 !== preg_match('/^[A-Za-z0-9_.]{1,64}$/', $key)) {
            throw new InvalidCacheKey(sprintf('Clé de cache « %s » refusée par la PSR-16.', $key));
        }
    }
}
