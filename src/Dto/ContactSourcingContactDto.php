<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `ContactSourcingContact` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class ContactSourcingContactDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $leadId = null,
        public ?string $role = null,
        public ?float $fitScore = null,
        public ?string $reasoning = null,
        public ?string $fullName = null,
        public ?string $jobTitle = null,
        public ?string $linkedinUrl = null,
        public ?string $country = null,
        public ?string $companyName = null,
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
            leadId: Cast::string($data['leadId'] ?? null),
            role: Cast::string($data['role'] ?? null),
            fitScore: Cast::float($data['fitScore'] ?? null),
            reasoning: Cast::string($data['reasoning'] ?? null),
            fullName: Cast::string($data['fullName'] ?? null),
            jobTitle: Cast::string($data['jobTitle'] ?? null),
            linkedinUrl: Cast::string($data['linkedinUrl'] ?? null),
            country: Cast::string($data['country'] ?? null),
            companyName: Cast::string($data['companyName'] ?? null),
            raw: $data,
        );
    }
}
