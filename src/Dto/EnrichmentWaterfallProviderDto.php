<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `EnrichmentWaterfallProvider` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class EnrichmentWaterfallProviderDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?int $order = null,
        public ?string $id = null,
        public ?bool $enabled = null,
        public ?string $image = null,
        public ?string $source = null,
        public ?bool $shuffled = null,
        public ?int $tier = null,
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
            order: Cast::int($data['order'] ?? null),
            id: Cast::string($data['id'] ?? null),
            enabled: Cast::bool($data['enabled'] ?? null),
            image: Cast::string($data['image'] ?? null),
            source: Cast::string($data['source'] ?? null),
            shuffled: Cast::bool($data['shuffled'] ?? null),
            tier: Cast::int($data['tier'] ?? null),
            raw: $data,
        );
    }
}
