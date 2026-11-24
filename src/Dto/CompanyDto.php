<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `Company` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class CompanyDto
{
    /**
     * @param list<FieldRejectionDto>|null $fieldRejections
     * @param array<array-key, mixed>      $raw             corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?string $teamId = null,
        public ?string $domain = null,
        public ?string $linkedinUrl = null,
        public ?string $linkedinUrlSalesNav = null,
        public ?CompanyFieldsDto $fields = null,
        public ?CompanyAccountPenetrationDto $accountPenetration = null,
        public ?string $createdBy = null,
        public ?string $ownerId = null,
        public ?\DateTimeImmutable $createdAt = null,
        public ?string $source = null,
        public ?array $fieldRejections = null,
        public ?CompanyCrmSyncDto $crmSync = null,
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
            domain: Cast::string($data['domain'] ?? null),
            linkedinUrl: Cast::string($data['linkedinUrl'] ?? null),
            linkedinUrlSalesNav: Cast::string($data['linkedinUrlSalesNav'] ?? null),
            fields: Cast::object($data['fields'] ?? null, CompanyFieldsDto::fromArray(...)),
            accountPenetration: Cast::object($data['accountPenetration'] ?? null, CompanyAccountPenetrationDto::fromArray(...)),
            createdBy: Cast::string($data['createdBy'] ?? null),
            ownerId: Cast::string($data['ownerId'] ?? null),
            createdAt: Cast::dateTime($data['createdAt'] ?? null),
            source: Cast::string($data['source'] ?? null),
            fieldRejections: Cast::objects($data['fieldRejections'] ?? null, FieldRejectionDto::fromArray(...)),
            crmSync: Cast::object($data['crmSync'] ?? null, CompanyCrmSyncDto::fromArray(...)),
            raw: $data,
        );
    }
}
