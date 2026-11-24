<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `ConditionBranch` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class ConditionBranchDto
{
    /**
     * @param list<string>|null       $emailStatusFilter
     * @param list<string>|null       $callStatusFilter
     * @param list<string>|null       $customValues
     * @param array<array-key, mixed> $raw               corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $sequenceId = null,
        public ?int $index = null,
        public ?bool $fallback = null,
        public ?string $key = null,
        public ?string $name = null,
        public ?int $delay = null,
        public ?string $delayType = null,
        public ?string $scoreComparator = null,
        public ?int $scoreThreshold = null,
        public ?array $emailStatusFilter = null,
        public ?array $callStatusFilter = null,
        public ?string $customField = null,
        public ?string $customOperator = null,
        public ?array $customValues = null,
        public ?string $selector = null,
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
            sequenceId: Cast::string($data['sequenceId'] ?? null),
            index: Cast::int($data['index'] ?? null),
            fallback: Cast::bool($data['fallback'] ?? null),
            key: Cast::string($data['key'] ?? null),
            name: Cast::string($data['name'] ?? null),
            delay: Cast::int($data['delay'] ?? null),
            delayType: Cast::string($data['delayType'] ?? null),
            scoreComparator: Cast::string($data['scoreComparator'] ?? null),
            scoreThreshold: Cast::int($data['scoreThreshold'] ?? null),
            emailStatusFilter: Cast::strings($data['emailStatusFilter'] ?? null),
            callStatusFilter: Cast::strings($data['callStatusFilter'] ?? null),
            customField: Cast::string($data['customField'] ?? null),
            customOperator: Cast::string($data['customOperator'] ?? null),
            customValues: Cast::strings($data['customValues'] ?? null),
            selector: Cast::string($data['selector'] ?? null),
            raw: $data,
        );
    }
}
