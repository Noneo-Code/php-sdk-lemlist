<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `CampaignSettings.schedule.endDate` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class CampaignSettingsScheduleEndDateDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $date = null,
        public ?string $time = null,
        public ?string $timezone = null,
        public ?string $action = null,
        public ?\DateTimeImmutable $at = null,
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
            date: Cast::string($data['date'] ?? null),
            time: Cast::string($data['time'] ?? null),
            timezone: Cast::string($data['timezone'] ?? null),
            action: Cast::string($data['action'] ?? null),
            at: Cast::dateTime($data['at'] ?? null),
            raw: $data,
        );
    }
}
