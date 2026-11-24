<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `TaskV2ListResponse` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class TaskV2ListResponseDto
{
    /**
     * @param list<TaskV2Dto>|null    $results
     * @param array<array-key, mixed> $raw     corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?array $results = null,
        public ?int $total = null,
        public ?int $limit = null,
        public ?int $page = null,
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
            results: Cast::objects($data['results'] ?? null, TaskV2Dto::fromArray(...)),
            total: Cast::int($data['total'] ?? null),
            limit: Cast::int($data['limit'] ?? null),
            page: Cast::int($data['page'] ?? null),
            raw: $data,
        );
    }
}
