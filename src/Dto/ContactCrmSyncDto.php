<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `Contact.crmSync` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class ContactCrmSyncDto
{
    /**
     * @param list<ContactCrmSyncErrorsItemDto>|null $errors
     * @param array<array-key, mixed>                $raw    corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $provider = null,
        public ?string $crmRecordId = null,
        public ?bool $syncDisabled = null,
        public ?bool $searching = null,
        public ?\DateTimeImmutable $notFoundAt = null,
        public ?array $errors = null,
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
            provider: Cast::string($data['provider'] ?? null),
            crmRecordId: Cast::string($data['crmRecordId'] ?? null),
            syncDisabled: Cast::bool($data['syncDisabled'] ?? null),
            searching: Cast::bool($data['searching'] ?? null),
            notFoundAt: Cast::dateTime($data['notFoundAt'] ?? null),
            errors: Cast::objects($data['errors'] ?? null, ContactCrmSyncErrorsItemDto::fromArray(...)),
            raw: $data,
        );
    }
}
