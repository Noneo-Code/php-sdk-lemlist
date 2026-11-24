<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `Contact.campaigns[]` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class ContactCampaignsItemDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $campaignId = null,
        public ?string $campaignState = null,
        public ?string $leadState = null,
        public ?string $leadId = null,
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
            campaignId: Cast::string($data['campaignId'] ?? null),
            campaignState: Cast::string($data['campaignState'] ?? null),
            leadState: Cast::string($data['leadState'] ?? null),
            leadId: Cast::string($data['leadId'] ?? null),
            raw: $data,
        );
    }
}
