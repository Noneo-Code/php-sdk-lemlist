<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Support;

/**
 * Conversions tolérantes utilisées par les `fromArray()` des DTO. La spec
 * lemlist décrit des types que l'API ne respecte pas toujours : plutôt que de
 * lever sur une réponse pourtant exploitable, une valeur inattendue devient
 * `null` — la donnée d'origine reste lisible dans la propriété `raw` du DTO.
 *
 * @internal
 */
final class Cast
{
    public static function string(mixed $value): ?string
    {
        return match (true) {
            is_string($value) => $value,
            is_int($value), is_float($value) => (string) $value,
            default => null,
        };
    }

    public static function int(mixed $value): ?int
    {
        if (is_int($value)) {
            return $value;
        }

        if (is_float($value)) {
            return floor($value) === $value ? (int) $value : null;
        }

        if (is_string($value) && 1 === preg_match('/^-?\d+$/', $value)) {
            return (int) $value;
        }

        return null;
    }

    public static function float(mixed $value): ?float
    {
        if (is_int($value) || is_float($value)) {
            return (float) $value;
        }

        return is_string($value) && is_numeric($value) ? (float) $value : null;
    }

    public static function bool(mixed $value): ?bool
    {
        return is_bool($value) ? $value : null;
    }

    public static function dateTime(mixed $value): ?\DateTimeImmutable
    {
        if (!is_string($value) || '' === $value) {
            return null;
        }

        try {
            return new \DateTimeImmutable($value);
        } catch (\Exception) {
            return null;
        }
    }

    /**
     * @return array<array-key, mixed>|null
     */
    public static function map(mixed $value): ?array
    {
        return is_array($value) ? $value : null;
    }

    /**
     * @return list<string>|null
     */
    public static function strings(mixed $value): ?array
    {
        return self::scalars($value, self::string(...));
    }

    /**
     * @return list<int>|null
     */
    public static function ints(mixed $value): ?array
    {
        return self::scalars($value, self::int(...));
    }

    /**
     * @return list<float>|null
     */
    public static function floats(mixed $value): ?array
    {
        return self::scalars($value, self::float(...));
    }

    /**
     * @return list<bool>|null
     */
    public static function bools(mixed $value): ?array
    {
        return self::scalars($value, self::bool(...));
    }

    /**
     * @template T
     *
     * @param callable(array<array-key, mixed>): T $factory
     *
     * @return T|null
     */
    public static function object(mixed $value, callable $factory): mixed
    {
        return is_array($value) ? $factory($value) : null;
    }

    /**
     * @template T
     *
     * @param callable(array<array-key, mixed>): T $factory
     *
     * @return list<T>|null
     */
    public static function objects(mixed $value, callable $factory): ?array
    {
        if (!is_array($value)) {
            return null;
        }

        $objects = [];

        foreach ($value as $item) {
            if (is_array($item)) {
                $objects[] = $factory($item);
            }
        }

        return $objects;
    }

    /**
     * @template T of scalar
     *
     * @param callable(mixed): (T|null) $cast
     *
     * @return list<T>|null
     */
    private static function scalars(mixed $value, callable $cast): ?array
    {
        if (!is_array($value)) {
            return null;
        }

        $items = [];

        foreach ($value as $item) {
            $casted = $cast($item);

            if (null !== $casted) {
                $items[] = $casted;
            }
        }

        return $items;
    }
}
