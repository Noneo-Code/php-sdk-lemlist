<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `Task` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class TaskDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?string $type = null,
        public ?string $title = null,
        public ?string $content = null,
        public ?string $text = null,
        public ?int $priority = null,
        public ?\DateTimeImmutable $dueDate = null,
        public ?string $userId = null,
        public ?string $leadId = null,
        public ?string $contactId = null,
        public ?string $campaignId = null,
        public ?string $sequenceId = null,
        public ?string $leadFirstName = null,
        public ?string $leadLastName = null,
        public ?string $leadCompanyName = null,
        public ?bool $manual = null,
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
            title: Cast::string($data['title'] ?? null),
            content: Cast::string($data['content'] ?? null),
            text: Cast::string($data['text'] ?? null),
            priority: Cast::int($data['priority'] ?? null),
            dueDate: Cast::dateTime($data['dueDate'] ?? null),
            userId: Cast::string($data['userId'] ?? null),
            leadId: Cast::string($data['leadId'] ?? null),
            contactId: Cast::string($data['contactId'] ?? null),
            campaignId: Cast::string($data['campaignId'] ?? null),
            sequenceId: Cast::string($data['sequenceId'] ?? null),
            leadFirstName: Cast::string($data['leadFirstName'] ?? null),
            leadLastName: Cast::string($data['leadLastName'] ?? null),
            leadCompanyName: Cast::string($data['leadCompanyName'] ?? null),
            manual: Cast::bool($data['manual'] ?? null),
            raw: $data,
        );
    }
}
