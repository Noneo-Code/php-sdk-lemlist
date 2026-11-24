<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `CampaignSettings.senders` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class CampaignSettingsSendersDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?bool $espMatching = null,
        public ?CampaignSettingsSendersEspRoutingDto $espRouting = null,
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
            espMatching: Cast::bool($data['espMatching'] ?? null),
            espRouting: Cast::object($data['espRouting'] ?? null, CampaignSettingsSendersEspRoutingDto::fromArray(...)),
            raw: $data,
        );
    }
}
