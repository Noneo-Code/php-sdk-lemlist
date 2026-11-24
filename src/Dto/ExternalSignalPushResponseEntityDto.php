<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `ExternalSignalPushResponse.entity` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class ExternalSignalPushResponseEntityDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $type = null,
        public ?string $id = null,
        public ?bool $enriched = null,
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
            type: Cast::string($data['type'] ?? null),
            id: Cast::string($data['id'] ?? null),
            enriched: Cast::bool($data['enriched'] ?? null),
            raw: $data,
        );
    }
}
