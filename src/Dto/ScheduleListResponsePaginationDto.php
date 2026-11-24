<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `ScheduleListResponse.pagination` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class ScheduleListResponsePaginationDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?int $totalRecords = null,
        public ?int $currentPage = null,
        public ?int $nextPage = null,
        public ?int $totalPage = null,
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
            totalRecords: Cast::int($data['totalRecords'] ?? null),
            currentPage: Cast::int($data['currentPage'] ?? null),
            nextPage: Cast::int($data['nextPage'] ?? null),
            totalPage: Cast::int($data['totalPage'] ?? null),
            raw: $data,
        );
    }
}
