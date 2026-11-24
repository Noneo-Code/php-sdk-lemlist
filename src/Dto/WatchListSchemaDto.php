<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `WatchListSchema` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class WatchListSchemaDto
{
    /**
     * @param list<WatchListFilterDto>|null $filters
     * @param array<array-key, mixed>       $raw     corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?string $name = null,
        public ?string $type = null,
        public ?string $status = null,
        public ?string $entity = null,
        public ?string $segmentType = null,
        public ?string $signalProcessingType = null,
        public ?WatchListSchemaSignalOpportunityTemplateDto $signalOpportunityTemplate = null,
        public ?array $filters = null,
        public ?string $emoji = null,
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
            type: Cast::string($data['type'] ?? null),
            status: Cast::string($data['status'] ?? null),
            entity: Cast::string($data['entity'] ?? null),
            segmentType: Cast::string($data['segmentType'] ?? null),
            signalProcessingType: Cast::string($data['signalProcessingType'] ?? null),
            signalOpportunityTemplate: Cast::object($data['signalOpportunityTemplate'] ?? null, WatchListSchemaSignalOpportunityTemplateDto::fromArray(...)),
            filters: Cast::objects($data['filters'] ?? null, WatchListFilterDto::fromArray(...)),
            emoji: Cast::string($data['emoji'] ?? null),
            raw: $data,
        );
    }
}
