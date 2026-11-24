<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `TaskV2FiltersResponse` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class TaskV2FiltersResponseDto
{
    /**
     * @param list<TaskV2FilterDescriptorDto>|null $results
     * @param array<array-key, mixed>              $raw     corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?array $results = null,
        public ?int $total = null,
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
            results: Cast::objects($data['results'] ?? null, TaskV2FilterDescriptorDto::fromArray(...)),
            total: Cast::int($data['total'] ?? null),
            raw: $data,
        );
    }
}
