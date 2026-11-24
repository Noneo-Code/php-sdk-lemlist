<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `Contact` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class ContactDto
{
    /**
     * @param array<array-key, mixed>|null            $fields
     * @param list<ContactCampaignsItemDto>|null      $campaigns
     * @param list<ContactPhonesStatusesItemDto>|null $phonesStatuses
     * @param list<FieldRejectionDto>|null            $fieldRejections
     * @param array<array-key, mixed>                 $raw             corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?string $teamId = null,
        public ?string $fullName = null,
        public ?string $email = null,
        public ?array $fields = null,
        public ?array $campaigns = null,
        public ?string $linkedinUrl = null,
        public ?string $linkedinUrlSalesNav = null,
        public ?string $ownerId = null,
        public ?\DateTimeImmutable $createdAt = null,
        public ?string $createdBy = null,
        public ?bool $unsubscribed = null,
        public ?array $phonesStatuses = null,
        public ?ContactCrmSyncDto $crmSync = null,
        public ?array $fieldRejections = null,
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
            teamId: Cast::string($data['teamId'] ?? null),
            fullName: Cast::string($data['fullName'] ?? null),
            email: Cast::string($data['email'] ?? null),
            fields: Cast::map($data['fields'] ?? null),
            campaigns: Cast::objects($data['campaigns'] ?? null, ContactCampaignsItemDto::fromArray(...)),
            linkedinUrl: Cast::string($data['linkedinUrl'] ?? null),
            linkedinUrlSalesNav: Cast::string($data['linkedinUrlSalesNav'] ?? null),
            ownerId: Cast::string($data['ownerId'] ?? null),
            createdAt: Cast::dateTime($data['createdAt'] ?? null),
            createdBy: Cast::string($data['createdBy'] ?? null),
            unsubscribed: Cast::bool($data['unsubscribed'] ?? null),
            phonesStatuses: Cast::objects($data['phonesStatuses'] ?? null, ContactPhonesStatusesItemDto::fromArray(...)),
            crmSync: Cast::object($data['crmSync'] ?? null, ContactCrmSyncDto::fromArray(...)),
            fieldRejections: Cast::objects($data['fieldRejections'] ?? null, FieldRejectionDto::fromArray(...)),
            raw: $data,
        );
    }
}
