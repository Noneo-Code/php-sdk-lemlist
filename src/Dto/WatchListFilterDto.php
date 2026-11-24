<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `WatchListFilter` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class WatchListFilterDto
{
    /**
     * @param array<array-key, mixed>|null $in
     * @param list<string>|null            $out
     * @param array<array-key, mixed>      $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $filterId = null,
        public ?array $in = null,
        public ?array $out = null,
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
            in: Cast::map($data['in'] ?? null),
            out: Cast::strings($data['out'] ?? null),
            raw: $data,
        );
    }
}
