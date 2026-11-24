<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Generator;

/**
 * Règles de nommage du code généré.
 */
final class Naming
{
    private const int MAX_DESCRIPTION_LENGTH = 160;

    /**
     * Un résumé d'opération, un tag ou un nom de propriété devient un nom de
     * classe. Un sigle (`CRM`, `ID`, `SMS`) est ramené à une capitale suivie de
     * minuscules pour que le nom de méthode dérivé reste lisible :
     * `getTeamCrmUsers()` plutôt que `getTeamCRMUsers()`.
     */
    public static function pascal(string $text): string
    {
        preg_match_all('/[A-Za-z0-9]+/', $text, $matches);

        $name = '';

        foreach ($matches[0] as $word) {
            if (1 === preg_match('/^[A-Z]{2,}s?$/', $word)) {
                $word = strtolower($word);
            }

            $name .= ucfirst($word);
        }

        return $name;
    }

    public static function camel(string $pascal): string
    {
        return lcfirst($pascal);
    }

    /**
     * Une description de la spec — du Markdown sur plusieurs lignes — devient
     * une phrase de docblock : première phrase seulement, sans point final
     * (la règle `phpdoc_annotation_without_dot`) ni séquence fermant le
     * commentaire.
     */
    public static function description(string $text): string
    {
        $text = trim((string) preg_replace('/\s+/', ' ', $text));
        $text = (string) preg_replace('/^(.*?[.!?])\s.*$/', '$1', $text);
        $text = str_replace('*/', '* /', rtrim($text, '. '));

        if (mb_strlen($text) > self::MAX_DESCRIPTION_LENGTH) {
            $text = rtrim(mb_substr($text, 0, self::MAX_DESCRIPTION_LENGTH - 1)).'…';
        }

        return $text;
    }

    /**
     * Un paramètre dont le nom annonce un secret reçoit
     * `#[\SensitiveParameter]` : sans lui, sa valeur apparaîtrait en clair
     * dans toute trace conservant ses arguments.
     */
    public static function isSensitive(string $name): bool
    {
        return 1 === preg_match('/password|secret|token|api_?key|credential/i', $name);
    }
}
