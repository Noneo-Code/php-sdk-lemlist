<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Generator;

/**
 * Lecture typée d'un fragment de la spec : le JSON décodé n'est que du
 * `mixed`, et chaque accès demanderait sinon sa propre vérification.
 */
final readonly class Node
{
    /**
     * @param array<array-key, mixed> $data
     */
    public function __construct(private array $data)
    {
    }

    public static function of(mixed $value): self
    {
        return new self(is_array($value) ? $value : []);
    }

    public function isEmpty(): bool
    {
        return [] === $this->data;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function value(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    public function string(string $key): string
    {
        $value = $this->data[$key] ?? null;

        return is_string($value) ? $value : '';
    }

    public function get(string $key): self
    {
        return self::of($this->data[$key] ?? null);
    }

    /**
     * @return array<string, self>
     */
    public function map(string $key): array
    {
        $nodes = [];

        foreach ($this->get($key)->data as $name => $value) {
            $nodes[(string) $name] = self::of($value);
        }

        return $nodes;
    }

    /**
     * @return list<self>
     */
    public function list(string $key): array
    {
        return array_values($this->map($key));
    }

    /**
     * @return list<string>
     */
    public function strings(string $key): array
    {
        $strings = [];

        foreach ($this->get($key)->data as $value) {
            if (is_scalar($value)) {
                $strings[] = is_bool($value) ? ($value ? 'true' : 'false') : (string) $value;
            }
        }

        return $strings;
    }
}
