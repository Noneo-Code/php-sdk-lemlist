<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `SnippetListResponse` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class SnippetListResponseDto
{
    /**
     * @param list<SnippetDto>|null   $data
     * @param array<array-key, mixed> $raw  corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?array $data = null,
        public ?PageMetaDto $meta = null,
        public array $raw = [],
    ) {
    }

    /**
     * Toute valeur absente ou d'un type inattendu devient `null` ; elle reste
     * lisible dans `raw`.
     *
     * @param array<array-key, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            data: Cast::objects($data['data'] ?? null, SnippetDto::fromArray(...)),
            meta: Cast::object($data['meta'] ?? null, PageMetaDto::fromArray(...)),
            raw: $data,
        );
    }
}
