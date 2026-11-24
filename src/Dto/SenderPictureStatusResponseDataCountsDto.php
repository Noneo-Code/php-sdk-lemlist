<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `SenderPictureStatusResponse.data.counts` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class SenderPictureStatusResponseDataCountsDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?int $total = null,
        public ?int $synced = null,
        public ?int $notSynced = null,
        public ?int $queued = null,
        public ?int $syncing = null,
        public ?int $failed = null,
        public ?int $notSupported = null,
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
            total: Cast::int($data['total'] ?? null),
            synced: Cast::int($data['synced'] ?? null),
            notSynced: Cast::int($data['notSynced'] ?? null),
            queued: Cast::int($data['queued'] ?? null),
            syncing: Cast::int($data['syncing'] ?? null),
            failed: Cast::int($data['failed'] ?? null),
            notSupported: Cast::int($data['notSupported'] ?? null),
            raw: $data,
        );
    }
}
