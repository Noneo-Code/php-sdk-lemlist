<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `Campaign` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class CampaignDto
{
    /**
     * @param list<string>|null                 $labels
     * @param list<string>|null                 $scheduleIds
     * @param list<string>|null                 $errors
     * @param list<CampaignSendersItemDto>|null $senders
     * @param array<array-key, mixed>           $raw         corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?string $name = null,
        public ?string $emoji = null,
        public ?array $labels = null,
        public ?string $folderId = null,
        public ?\DateTimeImmutable $createdAt = null,
        public ?string $createdBy = null,
        public ?string $status = null,
        public ?string $sequenceId = null,
        public ?array $scheduleIds = null,
        public ?string $timezone = null,
        public ?string $teamId = null,
        public ?bool $hasError = null,
        public ?array $errors = null,
        public ?CampaignCreatorDto $creator = null,
        public ?array $senders = null,
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
            name: Cast::string($data['name'] ?? null),
            emoji: Cast::string($data['emoji'] ?? null),
            labels: Cast::strings($data['labels'] ?? null),
            folderId: Cast::string($data['folderId'] ?? null),
            createdAt: Cast::dateTime($data['createdAt'] ?? null),
            createdBy: Cast::string($data['createdBy'] ?? null),
            status: Cast::string($data['status'] ?? null),
            sequenceId: Cast::string($data['sequenceId'] ?? null),
            scheduleIds: Cast::strings($data['scheduleIds'] ?? null),
            timezone: Cast::string($data['timezone'] ?? null),
            teamId: Cast::string($data['teamId'] ?? null),
            hasError: Cast::bool($data['hasError'] ?? null),
            errors: Cast::strings($data['errors'] ?? null),
            creator: Cast::object($data['creator'] ?? null, CampaignCreatorDto::fromArray(...)),
            senders: Cast::objects($data['senders'] ?? null, CampaignSendersItemDto::fromArray(...)),
            raw: $data,
        );
    }
}
