<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `CampaignSettings.onMeetingBooked` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class CampaignSettingsOnMeetingBookedDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $campaignProgress = null,
        public ?bool $propagateProgressToCompany = null,
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
            campaignProgress: Cast::string($data['campaignProgress'] ?? null),
            propagateProgressToCompany: Cast::bool($data['propagateProgressToCompany'] ?? null),
            raw: $data,
        );
    }
}
