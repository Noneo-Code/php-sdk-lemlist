<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `Campaign.creator` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class CampaignCreatorDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $userId = null,
        public ?string $userEmail = null,
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
            userId: Cast::string($data['userId'] ?? null),
            userEmail: Cast::string($data['userEmail'] ?? null),
            raw: $data,
        );
    }
}
