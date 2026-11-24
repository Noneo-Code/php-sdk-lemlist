<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `Activity` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class ActivityDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?string $type = null,
        public ?string $leadId = null,
        public ?string $campaignId = null,
        public ?string $sequenceId = null,
        public ?string $stepId = null,
        public ?float $sequenceStep = null,
        public ?float $totalSequenceStep = null,
        public ?float $journeyDepth = null,
        public ?\DateTimeImmutable $createdAt = null,
        public ?string $contactId = null,
        public ?string $leadEmail = null,
        public ?string $leadFirstName = null,
        public ?string $leadLastName = null,
        public ?string $leadCompanyName = null,
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
            type: Cast::string($data['type'] ?? null),
            leadId: Cast::string($data['leadId'] ?? null),
            campaignId: Cast::string($data['campaignId'] ?? null),
            sequenceId: Cast::string($data['sequenceId'] ?? null),
            stepId: Cast::string($data['stepId'] ?? null),
            sequenceStep: Cast::float($data['sequenceStep'] ?? null),
            totalSequenceStep: Cast::float($data['totalSequenceStep'] ?? null),
            journeyDepth: Cast::float($data['journeyDepth'] ?? null),
            createdAt: Cast::dateTime($data['createdAt'] ?? null),
            contactId: Cast::string($data['contactId'] ?? null),
            leadEmail: Cast::string($data['leadEmail'] ?? null),
            leadFirstName: Cast::string($data['leadFirstName'] ?? null),
            leadLastName: Cast::string($data['leadLastName'] ?? null),
            leadCompanyName: Cast::string($data['leadCompanyName'] ?? null),
            raw: $data,
        );
    }
}
