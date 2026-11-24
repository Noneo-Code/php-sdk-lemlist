<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `CampaignSettings.aiFeatures` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class CampaignSettingsAiFeaturesDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?bool $scoreReplies = null,
        public ?CampaignSettingsAiFeaturesOnInterestedReplyDto $onInterestedReply = null,
        public ?CampaignSettingsAiFeaturesOnNotInterestedReplyDto $onNotInterestedReply = null,
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
            scoreReplies: Cast::bool($data['scoreReplies'] ?? null),
            onInterestedReply: Cast::object($data['onInterestedReply'] ?? null, CampaignSettingsAiFeaturesOnInterestedReplyDto::fromArray(...)),
            onNotInterestedReply: Cast::object($data['onNotInterestedReply'] ?? null, CampaignSettingsAiFeaturesOnNotInterestedReplyDto::fromArray(...)),
            raw: $data,
        );
    }
}
