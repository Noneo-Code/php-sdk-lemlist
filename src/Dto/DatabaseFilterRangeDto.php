<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `DatabaseFilter.range` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class DatabaseFilterRangeDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?float $min = null,
        public ?float $max = null,
        public ?string $default = null,
        public ?bool $percentage = null,
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
            min: Cast::float($data['min'] ?? null),
            max: Cast::float($data['max'] ?? null),
            default: Cast::string($data['default'] ?? null),
            percentage: Cast::bool($data['percentage'] ?? null),
            raw: $data,
        );
    }
}
