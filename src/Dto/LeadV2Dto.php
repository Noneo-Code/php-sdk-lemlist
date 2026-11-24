<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `LeadV2` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class LeadV2Dto
{
    /**
     * @param array<array-key, mixed>|null $variables
     * @param array<array-key, mixed>|null $sendingUser
     * @param array<array-key, mixed>      $raw         corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?\DateTimeImmutable $createdAt = null,
        public ?\DateTimeImmutable $updatedAt = null,
        public ?bool $isPaused = null,
        public ?string $state = null,
        public ?string $status = null,
        public ?bool $personalized = null,
        public ?string $source = null,
        public ?array $variables = null,
        public ?string $contactId = null,
        public ?LeadV2EnrichmentDto $enrichment = null,
        public ?LeadV2CampaignDto $campaign = null,
        public ?array $sendingUser = null,
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
            _id: Cast::string($data['_id'] ?? null),
            createdAt: Cast::dateTime($data['createdAt'] ?? null),
            updatedAt: Cast::dateTime($data['updatedAt'] ?? null),
            isPaused: Cast::bool($data['isPaused'] ?? null),
            state: Cast::string($data['state'] ?? null),
            status: Cast::string($data['status'] ?? null),
            personalized: Cast::bool($data['personalized'] ?? null),
            source: Cast::string($data['source'] ?? null),
            variables: Cast::map($data['variables'] ?? null),
            contactId: Cast::string($data['contactId'] ?? null),
            enrichment: Cast::object($data['enrichment'] ?? null, LeadV2EnrichmentDto::fromArray(...)),
            campaign: Cast::object($data['campaign'] ?? null, LeadV2CampaignDto::fromArray(...)),
            sendingUser: Cast::map($data['sendingUser'] ?? null),
            raw: $data,
        );
    }
}
