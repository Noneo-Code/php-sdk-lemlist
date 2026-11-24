<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Http\Connector;

use Noneo\Sdk\Lemlist\Exception\UnexpectedResponseException;
use Saloon\Http\Response;

/**
 * Passage d'une réponse Saloon aux types PHP que rendent les ressources.
 *
 * @internal
 */
final class ResponseDecoder
{
    /**
     * Corps attendu sous forme d'objet ou de tableau JSON. Un corps vide — le
     * cas d'un 202 ou d'un 204 — vaut un objet vide.
     *
     * @return array<array-key, mixed>
     */
    public static function object(Response $response): array
    {
        $body = $response->body();

        if ('' === trim($body)) {
            return [];
        }

        try {
            $decoded = json_decode($body, true, flags: \JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            throw UnexpectedResponseException::forBody('La réponse lemlist n\'est pas du JSON valide.', $response->status(), $body);
        }

        if (!is_array($decoded)) {
            throw UnexpectedResponseException::forBody('La réponse lemlist devait être un objet ou un tableau JSON.', $response->status(), $body);
        }

        return $decoded;
    }

    /**
     * Corps attendu sous forme de liste d'objets ; tout item qui n'est pas un
     * objet est écarté.
     *
     * lemlist rend parfois, à la place de la liste documentée, une enveloppe
     * paginée (`{"campaigns": [...], "pagination": {...}}`) : la liste est
     * alors celle que l'enveloppe contient. Un objet dont on ne peut tirer
     * aucune liste sans deviner est refusé plutôt que converti en DTO vides.
     *
     * @return list<array<array-key, mixed>>
     */
    public static function items(Response $response): array
    {
        $decoded = self::object($response);

        if (!array_is_list($decoded)) {
            $lists = array_filter($decoded, static fn (mixed $value): bool => is_array($value) && array_is_list($value));

            if (1 !== count($lists)) {
                throw UnexpectedResponseException::forBody('La réponse lemlist devait être une liste.', $response->status(), $response->body());
            }

            $decoded = reset($lists);
        }

        $items = [];

        foreach ($decoded as $item) {
            if (is_array($item)) {
                $items[] = $item;
            }
        }

        return $items;
    }

    /**
     * Corps dont la spec ne décrit pas la forme : la valeur JSON telle quelle,
     * ou le texte brut si ce n'est pas du JSON.
     */
    public static function value(Response $response): mixed
    {
        $body = $response->body();

        if ('' === trim($body)) {
            return null;
        }

        try {
            return json_decode($body, true, flags: \JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return $body;
        }
    }

    public static function text(Response $response): string
    {
        return $response->body();
    }
}
