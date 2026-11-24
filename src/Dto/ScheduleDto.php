<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `Schedule` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class ScheduleDto
{
    /**
     * @param list<int>|null          $weekdays
     * @param array<array-key, mixed> $raw      corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?string $name = null,
        public ?int $secondsToWait = null,
        public ?string $timezone = null,
        public ?string $start = null,
        public ?string $end = null,
        public ?array $weekdays = null,
        public ?bool $public = null,
        public ?string $teamId = null,
        public ?string $createdBy = null,
        public ?\DateTimeImmutable $createdAt = null,
        public ?\DateTimeImmutable $deletedAt = null,
        public ?string $deletedBy = null,
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
            secondsToWait: Cast::int($data['secondsToWait'] ?? null),
            timezone: Cast::string($data['timezone'] ?? null),
            start: Cast::string($data['start'] ?? null),
            end: Cast::string($data['end'] ?? null),
            weekdays: Cast::ints($data['weekdays'] ?? null),
            public: Cast::bool($data['public'] ?? null),
            teamId: Cast::string($data['teamId'] ?? null),
            createdBy: Cast::string($data['createdBy'] ?? null),
            createdAt: Cast::dateTime($data['createdAt'] ?? null),
            deletedAt: Cast::dateTime($data['deletedAt'] ?? null),
            deletedBy: Cast::string($data['deletedBy'] ?? null),
            raw: $data,
        );
    }
}
