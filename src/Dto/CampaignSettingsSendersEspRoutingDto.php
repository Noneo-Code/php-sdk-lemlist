<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `CampaignSettings.senders.espRouting` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class CampaignSettingsSendersEspRoutingDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $gmail = null,
        public ?string $outlook = null,
        public ?string $other = null,
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
            gmail: Cast::string($data['gmail'] ?? null),
            outlook: Cast::string($data['outlook'] ?? null),
            other: Cast::string($data['other'] ?? null),
            raw: $data,
        );
    }
}
