<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `CampaignSettings.general` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class CampaignSettingsGeneralDto
{
    /**
     * @param list<CampaignSettingsGeneralLabelsItemDto>|null $labels
     * @param array<array-key, mixed>                         $raw    corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?array $labels = null,
        public ?string $sequenceId = null,
        public ?bool $sequenceSharing = null,
        public ?string $unsubscribeMode = null,
        public ?bool $addUnsubscribeLink = null,
        public ?string $unsubscribeLinkText = null,
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
            labels: Cast::objects($data['labels'] ?? null, CampaignSettingsGeneralLabelsItemDto::fromArray(...)),
            sequenceId: Cast::string($data['sequenceId'] ?? null),
            sequenceSharing: Cast::bool($data['sequenceSharing'] ?? null),
            unsubscribeMode: Cast::string($data['unsubscribeMode'] ?? null),
            addUnsubscribeLink: Cast::bool($data['addUnsubscribeLink'] ?? null),
            unsubscribeLinkText: Cast::string($data['unsubscribeLinkText'] ?? null),
            raw: $data,
        );
    }
}
