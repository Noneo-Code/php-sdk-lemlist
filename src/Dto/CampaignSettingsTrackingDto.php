<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `CampaignSettings.tracking` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class CampaignSettingsTrackingDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?bool $trackOpens = null,
        public ?bool $trackClicks = null,
        public ?bool $trackReplies = null,
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
            trackOpens: Cast::bool($data['trackOpens'] ?? null),
            trackClicks: Cast::bool($data['trackClicks'] ?? null),
            trackReplies: Cast::bool($data['trackReplies'] ?? null),
            raw: $data,
        );
    }
}
