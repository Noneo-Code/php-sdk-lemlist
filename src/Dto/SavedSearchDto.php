<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `SavedSearch` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class SavedSearchDto
{
    /**
     * @param list<PersonaFilterDto>|null $filters
     * @param array<array-key, mixed>     $raw     corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?string $name = null,
        public ?string $mode = null,
        public ?array $filters = null,
        public ?\DateTimeImmutable $createdAt = null,
        public ?float $lastResultsCount = null,
        public ?\DateTimeImmutable $lastResultsCountUpdatedAt = null,
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
            mode: Cast::string($data['mode'] ?? null),
            filters: Cast::objects($data['filters'] ?? null, PersonaFilterDto::fromArray(...)),
            createdAt: Cast::dateTime($data['createdAt'] ?? null),
            lastResultsCount: Cast::float($data['lastResultsCount'] ?? null),
            lastResultsCountUpdatedAt: Cast::dateTime($data['lastResultsCountUpdatedAt'] ?? null),
            raw: $data,
        );
    }
}
