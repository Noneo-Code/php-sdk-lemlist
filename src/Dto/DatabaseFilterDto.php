<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `DatabaseFilter` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class DatabaseFilterDto
{
    /**
     * @param list<string>|null       $mode
     * @param list<string>|null       $values
     * @param array<array-key, mixed> $raw    corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $filterId = null,
        public ?string $description = null,
        public ?array $mode = null,
        public ?string $type = null,
        public ?array $values = null,
        public ?DatabaseFilterRangeDto $range = null,
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
            filterId: Cast::string($data['filterId'] ?? null),
            description: Cast::string($data['description'] ?? null),
            mode: Cast::strings($data['mode'] ?? null),
            type: Cast::string($data['type'] ?? null),
            values: Cast::strings($data['values'] ?? null),
            range: Cast::object($data['range'] ?? null, DatabaseFilterRangeDto::fromArray(...)),
            raw: $data,
        );
    }
}
