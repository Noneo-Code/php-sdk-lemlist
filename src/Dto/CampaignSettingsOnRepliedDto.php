<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `CampaignSettings.onReplied` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class CampaignSettingsOnRepliedDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?bool $createNewTask = null,
        public ?string $campaignProgress = null,
        public ?bool $propagateProgressToCompany = null,
        public ?bool $disableOutOfOffice = null,
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
            createNewTask: Cast::bool($data['createNewTask'] ?? null),
            campaignProgress: Cast::string($data['campaignProgress'] ?? null),
            propagateProgressToCompany: Cast::bool($data['propagateProgressToCompany'] ?? null),
            disableOutOfOffice: Cast::bool($data['disableOutOfOffice'] ?? null),
            raw: $data,
        );
    }
}
