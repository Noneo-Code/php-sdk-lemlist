<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `DeliverabilityAlert` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class DeliverabilityAlertDto
{
    /**
     * @param list<string>|null       $scopeEntities
     * @param array<array-key, mixed> $raw           corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?string $teamId = null,
        public ?string $createdBy = null,
        public ?\DateTimeImmutable $createdAt = null,
        public ?\DateTimeImmutable $updatedAt = null,
        public ?string $widget = null,
        public ?string $metric = null,
        public ?string $severity = null,
        public ?string $scope = null,
        public ?array $scopeEntities = null,
        public ?float $threshold = null,
        public ?string $comparisonOperator = null,
        public ?int $periodDays = null,
        public ?string $periodMode = null,
        public ?DeliverabilityAlertChannelConfigDto $channelConfig = null,
        public ?bool $enabled = null,
        public ?\DateTimeImmutable $lastCheckedAt = null,
        public ?\DateTimeImmutable $lastTriggeredAt = null,
        public ?int $recheckDelayHours = null,
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
            createdBy: Cast::string($data['createdBy'] ?? null),
            createdAt: Cast::dateTime($data['createdAt'] ?? null),
            updatedAt: Cast::dateTime($data['updatedAt'] ?? null),
            widget: Cast::string($data['widget'] ?? null),
            metric: Cast::string($data['metric'] ?? null),
            severity: Cast::string($data['severity'] ?? null),
            scope: Cast::string($data['scope'] ?? null),
            scopeEntities: Cast::strings($data['scopeEntities'] ?? null),
            threshold: Cast::float($data['threshold'] ?? null),
            comparisonOperator: Cast::string($data['comparisonOperator'] ?? null),
            periodDays: Cast::int($data['periodDays'] ?? null),
            periodMode: Cast::string($data['periodMode'] ?? null),
            channelConfig: Cast::object($data['channelConfig'] ?? null, DeliverabilityAlertChannelConfigDto::fromArray(...)),
            enabled: Cast::bool($data['enabled'] ?? null),
            lastCheckedAt: Cast::dateTime($data['lastCheckedAt'] ?? null),
            lastTriggeredAt: Cast::dateTime($data['lastTriggeredAt'] ?? null),
            recheckDelayHours: Cast::int($data['recheckDelayHours'] ?? null),
            raw: $data,
        );
    }
}
