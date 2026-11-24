<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `PersonaFilter` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class PersonaFilterDto
{
    /**
     * @param list<string>|null       $in
     * @param list<string>|null       $out
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $filterId = null,
        public ?array $in = null,
        public ?array $out = null,
        public ?bool $exactMatch = null,
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
            in: Cast::strings($data['in'] ?? null),
            out: Cast::strings($data['out'] ?? null),
            exactMatch: Cast::bool($data['exactMatch'] ?? null),
            raw: $data,
        );
    }
}
