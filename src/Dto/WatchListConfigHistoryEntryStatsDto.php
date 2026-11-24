<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `WatchListConfigHistoryEntry.stats` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class WatchListConfigHistoryEntryStatsDto
{
    /**
     * @param array<array-key, mixed>|null $campaigns
     * @param array<array-key, mixed>      $raw       corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?int $signalsCount = null,
        public ?array $campaigns = null,
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
            signalsCount: Cast::int($data['signalsCount'] ?? null),
            campaigns: Cast::map($data['campaigns'] ?? null),
            raw: $data,
        );
    }
}
