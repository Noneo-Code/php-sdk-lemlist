<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `CampaignSettings.automation` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class CampaignSettingsAutomationDto
{
    /**
     * @param list<string>|null       $autoReviewConditions
     * @param array<array-key, mixed> $raw                  corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?bool $autoReview = null,
        public ?array $autoReviewConditions = null,
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
            autoReview: Cast::bool($data['autoReview'] ?? null),
            autoReviewConditions: Cast::strings($data['autoReviewConditions'] ?? null),
            raw: $data,
        );
    }
}
