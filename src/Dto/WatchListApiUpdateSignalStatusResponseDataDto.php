<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `WatchListApiUpdateSignalStatusResponse.data` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class WatchListApiUpdateSignalStatusResponseDataDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?int $updatedCount = null,
        public ?int $requestedCount = null,
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
            updatedCount: Cast::int($data['updatedCount'] ?? null),
            requestedCount: Cast::int($data['requestedCount'] ?? null),
            raw: $data,
        );
    }
}
