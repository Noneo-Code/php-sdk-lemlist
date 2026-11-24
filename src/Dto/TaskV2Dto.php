<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `TaskV2` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class TaskV2Dto
{
    /**
     * @param array<array-key, mixed>|null $contact
     * @param array<array-key, mixed>|null $company
     * @param array<array-key, mixed>      $raw     corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?string $objectType = null,
        public ?string $recordId = null,
        public ?string $contactId = null,
        public ?string $companyId = null,
        public ?string $leadId = null,
        public ?string $campaignId = null,
        public ?string $assignedTo = null,
        public ?string $title = null,
        public ?string $message = null,
        public ?string $text = null,
        public ?string $type = null,
        public ?string $channel = null,
        public ?string $status = null,
        public ?int $priority = null,
        public ?\DateTimeImmutable $dueDate = null,
        public ?\DateTimeImmutable $completedAt = null,
        public ?bool $manual = null,
        public ?string $ownerName = null,
        public ?TaskV2CampaignDto $campaign = null,
        public ?string $leadFirstName = null,
        public ?string $leadLastName = null,
        public ?string $leadCompanyName = null,
        public ?array $contact = null,
        public ?array $company = null,
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
            objectType: Cast::string($data['objectType'] ?? null),
            recordId: Cast::string($data['recordId'] ?? null),
            contactId: Cast::string($data['contactId'] ?? null),
            companyId: Cast::string($data['companyId'] ?? null),
            leadId: Cast::string($data['leadId'] ?? null),
            campaignId: Cast::string($data['campaignId'] ?? null),
            assignedTo: Cast::string($data['assignedTo'] ?? null),
            title: Cast::string($data['title'] ?? null),
            message: Cast::string($data['message'] ?? null),
            text: Cast::string($data['text'] ?? null),
            type: Cast::string($data['type'] ?? null),
            channel: Cast::string($data['channel'] ?? null),
            status: Cast::string($data['status'] ?? null),
            priority: Cast::int($data['priority'] ?? null),
            dueDate: Cast::dateTime($data['dueDate'] ?? null),
            completedAt: Cast::dateTime($data['completedAt'] ?? null),
            manual: Cast::bool($data['manual'] ?? null),
            ownerName: Cast::string($data['ownerName'] ?? null),
            campaign: Cast::object($data['campaign'] ?? null, TaskV2CampaignDto::fromArray(...)),
            leadFirstName: Cast::string($data['leadFirstName'] ?? null),
            leadLastName: Cast::string($data['leadLastName'] ?? null),
            leadCompanyName: Cast::string($data['leadCompanyName'] ?? null),
            contact: Cast::map($data['contact'] ?? null),
            company: Cast::map($data['company'] ?? null),
            raw: $data,
        );
    }
}
