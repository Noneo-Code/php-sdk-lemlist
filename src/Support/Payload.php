<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Support;

/**
 * Mise en forme des paramètres avant envoi. Un argument laissé à `null` n'est
 * pas transmis : c'est ce qui distingue « ne pas toucher » de « mettre à
 * faux » ou « vider ».
 *
 * @internal
 */
final class Payload
{
    /**
     * Format des dates attendu par lemlist : ISO 8601 en UTC, à la milliseconde.
     */
    private const string DATE_FORMAT = 'Y-m-d\TH:i:s.v\Z';

    /**
     * `http_build_query()` rendrait `true` en `1` et `false` en `0` ; lemlist
     * attend les mots. Une liste est laissée telle quelle : elle part en
     * notation à crochets (`type[0]=a&type[1]=b`), celle que lemlist documente.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     */
    public static function query(array $parameters): array
    {
        $query = [];

        foreach ($parameters as $name => $value) {
            if (null === $value) {
                continue;
            }

            $query[$name] = match (true) {
                is_bool($value) => self::spell($value),
                $value instanceof \DateTimeInterface => self::formatDate($value),
                is_array($value) => array_map(self::spell(...), $value),
                default => $value,
            };
        }

        return $query;
    }

    /**
     * Les champs nommés l'emportent sur `$additional` : un champ documenté
     * passé en argument ne peut pas être écrasé par mégarde.
     *
     * @param array<string, mixed> $fields
     * @param array<string, mixed> $additional
     *
     * @return array<string, mixed>
     */
    public static function body(array $fields, array $additional = []): array
    {
        $body = $additional;

        foreach ($fields as $name => $value) {
            if (null === $value) {
                continue;
            }

            unset($body[$name]);
            $body[$name] = $value instanceof \DateTimeInterface ? self::formatDate($value) : $value;
        }

        return $body;
    }

    /**
     * Ouvre le fichier d'un envoi multipart. L'échec est levé ici, avant tout
     * appel réseau, plutôt que sous la forme d'un avertissement PHP.
     *
     * @return resource
     */
    public static function file(string $path)
    {
        $stream = is_file($path) && is_readable($path) ? fopen($path, 'r') : false;

        if (false === $stream) {
            throw new \InvalidArgumentException(sprintf('Fichier introuvable ou illisible : %s', $path));
        }

        return $stream;
    }

    private static function formatDate(\DateTimeInterface $date): string
    {
        return \DateTimeImmutable::createFromInterface($date)
            ->setTimezone(new \DateTimeZone('UTC'))
            ->format(self::DATE_FORMAT);
    }

    private static function spell(mixed $value): mixed
    {
        return is_bool($value) ? ($value ? 'true' : 'false') : $value;
    }
}
