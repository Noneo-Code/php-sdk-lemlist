<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `ContactSourcingRun` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class ContactSourcingRunDto
{
    /**
     * @param list<ContactSourcingContactDto>|null $contacts
     * @param array<array-key, mixed>              $raw      corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $runId = null,
        public ?string $companyId = null,
        public ?string $status = null,
        public ?\DateTimeImmutable $ranAt = null,
        public ?\DateTimeImmutable $completedAt = null,
        public ?string $reasoning = null,
        public ?string $error = null,
        public ?array $contacts = null,
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
            runId: Cast::string($data['runId'] ?? null),
            companyId: Cast::string($data['companyId'] ?? null),
            status: Cast::string($data['status'] ?? null),
            ranAt: Cast::dateTime($data['ranAt'] ?? null),
            completedAt: Cast::dateTime($data['completedAt'] ?? null),
            reasoning: Cast::string($data['reasoning'] ?? null),
            error: Cast::string($data['error'] ?? null),
            contacts: Cast::objects($data['contacts'] ?? null, ContactSourcingContactDto::fromArray(...)),
            raw: $data,
        );
    }
}
