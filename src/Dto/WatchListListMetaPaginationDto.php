<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `WatchListListMeta.pagination` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class WatchListListMetaPaginationDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?int $page = null,
        public ?int $limit = null,
        public ?int $totalRecords = null,
        public ?int $totalPages = null,
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
            page: Cast::int($data['page'] ?? null),
            limit: Cast::int($data['limit'] ?? null),
            totalRecords: Cast::int($data['totalRecords'] ?? null),
            totalPages: Cast::int($data['totalPages'] ?? null),
            raw: $data,
        );
    }
}
