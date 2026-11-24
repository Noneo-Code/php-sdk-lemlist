<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `Label` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class LabelDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?string $name = null,
        public ?string $color = null,
        public ?\DateTimeImmutable $createdAt = null,
        public ?string $createdBy = null,
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
            color: Cast::string($data['color'] ?? null),
            createdAt: Cast::dateTime($data['createdAt'] ?? null),
            createdBy: Cast::string($data['createdBy'] ?? null),
            raw: $data,
        );
    }
}
