<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `WatchListSchema.signalOpportunityTemplate` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class WatchListSchemaSignalOpportunityTemplateDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $ownerType = null,
        public ?string $ownerId = null,
        public ?string $type = null,
        public ?int $priority = null,
        public ?WatchListSchemaSignalOpportunityTemplateDataDto $data = null,
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
            ownerType: Cast::string($data['ownerType'] ?? null),
            ownerId: Cast::string($data['ownerId'] ?? null),
            type: Cast::string($data['type'] ?? null),
            priority: Cast::int($data['priority'] ?? null),
            data: Cast::object($data['data'] ?? null, WatchListSchemaSignalOpportunityTemplateDataDto::fromArray(...)),
            raw: $data,
        );
    }
}
