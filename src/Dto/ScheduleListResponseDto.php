<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `ScheduleListResponse` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class ScheduleListResponseDto
{
    /**
     * @param list<ScheduleDto>|null  $schedules
     * @param array<array-key, mixed> $raw       corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?array $schedules = null,
        public ?ScheduleListResponsePaginationDto $pagination = null,
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
            schedules: Cast::objects($data['schedules'] ?? null, ScheduleDto::fromArray(...)),
            pagination: Cast::object($data['pagination'] ?? null, ScheduleListResponsePaginationDto::fromArray(...)),
            raw: $data,
        );
    }
}
