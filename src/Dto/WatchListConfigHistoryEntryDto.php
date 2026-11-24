<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `WatchListConfigHistoryEntry` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class WatchListConfigHistoryEntryDto
{
    /**
     * @param list<WatchListFilterDto>|null $filters
     * @param array<array-key, mixed>       $raw     corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?\DateTimeImmutable $startDate = null,
        public ?\DateTimeImmutable $endDate = null,
        public ?string $createdBy = null,
        public ?string $name = null,
        public ?string $emoji = null,
        public ?string $type = null,
        public ?string $entity = null,
        public ?string $segmentType = null,
        public ?array $filters = null,
        public ?string $signalProcessingType = null,
        public ?WatchListConfigHistoryEntryStatsDto $stats = null,
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
            startDate: Cast::dateTime($data['startDate'] ?? null),
            endDate: Cast::dateTime($data['endDate'] ?? null),
            createdBy: Cast::string($data['createdBy'] ?? null),
            name: Cast::string($data['name'] ?? null),
            emoji: Cast::string($data['emoji'] ?? null),
            type: Cast::string($data['type'] ?? null),
            entity: Cast::string($data['entity'] ?? null),
            segmentType: Cast::string($data['segmentType'] ?? null),
            filters: Cast::objects($data['filters'] ?? null, WatchListFilterDto::fromArray(...)),
            signalProcessingType: Cast::string($data['signalProcessingType'] ?? null),
            stats: Cast::object($data['stats'] ?? null, WatchListConfigHistoryEntryStatsDto::fromArray(...)),
            raw: $data,
        );
    }
}
