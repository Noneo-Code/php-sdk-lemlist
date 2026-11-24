<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `Webhook` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class WebhookDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?string $targetUrl = null,
        public ?string $type = null,
        public ?string $campaignId = null,
        public ?\DateTimeImmutable $createdAt = null,
        public ?int $zapId = null,
        public ?bool $disabled = null,
        public ?string $disabledReason = null,
        public ?\DateTimeImmutable $disabledAt = null,
        public mixed $lastErrorStatus = null,
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
            targetUrl: Cast::string($data['targetUrl'] ?? null),
            type: Cast::string($data['type'] ?? null),
            campaignId: Cast::string($data['campaignId'] ?? null),
            createdAt: Cast::dateTime($data['createdAt'] ?? null),
            zapId: Cast::int($data['zapId'] ?? null),
            disabled: Cast::bool($data['disabled'] ?? null),
            disabledReason: Cast::string($data['disabledReason'] ?? null),
            disabledAt: Cast::dateTime($data['disabledAt'] ?? null),
            lastErrorStatus: $data['lastErrorStatus'] ?? null,
            raw: $data,
        );
    }
}
