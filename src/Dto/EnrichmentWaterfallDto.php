<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `EnrichmentWaterfall` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class EnrichmentWaterfallDto
{
    /**
     * @param list<EnrichmentWaterfallProviderDto>|null $providers
     * @param array<array-key, mixed>                   $raw       corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $id = null,
        public ?string $type = null,
        public ?string $name = null,
        public ?bool $isDefault = null,
        public ?string $editor = null,
        public ?EnrichmentWaterfallConditionsDto $conditions = null,
        public ?array $providers = null,
        public ?\DateTimeImmutable $createdAt = null,
        public ?\DateTimeImmutable $updatedAt = null,
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
            id: Cast::string($data['id'] ?? null),
            type: Cast::string($data['type'] ?? null),
            name: Cast::string($data['name'] ?? null),
            isDefault: Cast::bool($data['isDefault'] ?? null),
            editor: Cast::string($data['editor'] ?? null),
            conditions: Cast::object($data['conditions'] ?? null, EnrichmentWaterfallConditionsDto::fromArray(...)),
            providers: Cast::objects($data['providers'] ?? null, EnrichmentWaterfallProviderDto::fromArray(...)),
            createdAt: Cast::dateTime($data['createdAt'] ?? null),
            updatedAt: Cast::dateTime($data['updatedAt'] ?? null),
            raw: $data,
        );
    }
}
