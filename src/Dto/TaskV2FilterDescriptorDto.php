<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `TaskV2FilterDescriptor` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class TaskV2FilterDescriptorDto
{
    /**
     * @param list<string>|null       $operators
     * @param list<string>|null       $values
     * @param array<array-key, mixed> $raw       corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $field = null,
        public ?string $label = null,
        public ?string $scope = null,
        public ?string $type = null,
        public ?bool $custom = null,
        public ?array $operators = null,
        public ?string $queryParam = null,
        public ?array $values = null,
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
            field: Cast::string($data['field'] ?? null),
            label: Cast::string($data['label'] ?? null),
            scope: Cast::string($data['scope'] ?? null),
            type: Cast::string($data['type'] ?? null),
            custom: Cast::bool($data['custom'] ?? null),
            operators: Cast::strings($data['operators'] ?? null),
            queryParam: Cast::string($data['queryParam'] ?? null),
            values: Cast::strings($data['values'] ?? null),
            raw: $data,
        );
    }
}
