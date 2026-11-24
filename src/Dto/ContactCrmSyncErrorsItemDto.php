<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `Contact.crmSync.errors[]` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class ContactCrmSyncErrorsItemDto
{
    /**
     * @param array<array-key, mixed>|null $metadata
     * @param array<array-key, mixed>      $raw      corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $type = null,
        public ?string $reason = null,
        public ?\DateTimeImmutable $raisedAt = null,
        public ?array $metadata = null,
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
            type: Cast::string($data['type'] ?? null),
            reason: Cast::string($data['reason'] ?? null),
            raisedAt: Cast::dateTime($data['raisedAt'] ?? null),
            metadata: Cast::map($data['metadata'] ?? null),
            raw: $data,
        );
    }
}
