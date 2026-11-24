<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `CampaignSettings.aiFeatures.onNotInterestedReply` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class CampaignSettingsAiFeaturesOnNotInterestedReplyDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?bool $enabled = null,
        public ?bool $pauseAllCampaignsForLead = null,
        public ?bool $pauseCampaignForCompany = null,
        public ?bool $pauseAllCampaignsForCompany = null,
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
            enabled: Cast::bool($data['enabled'] ?? null),
            pauseAllCampaignsForLead: Cast::bool($data['pauseAllCampaignsForLead'] ?? null),
            pauseCampaignForCompany: Cast::bool($data['pauseCampaignForCompany'] ?? null),
            pauseAllCampaignsForCompany: Cast::bool($data['pauseAllCampaignsForCompany'] ?? null),
            raw: $data,
        );
    }
}
