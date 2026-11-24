<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `CampaignSettings.schedule` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class CampaignSettingsScheduleDto
{
    /**
     * @param list<string>|null       $scheduleIds
     * @param list<string>|null       $holidayCountries
     * @param array<array-key, mixed> $raw              corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?bool $isTimezoneBasedSchedule = null,
        public ?string $timezoneBasedScheduleId = null,
        public ?array $scheduleIds = null,
        public ?array $holidayCountries = null,
        public ?CampaignSettingsScheduleSendingPatternDto $sendingPattern = null,
        public ?CampaignSettingsScheduleEndDateDto $endDate = null,
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
            isTimezoneBasedSchedule: Cast::bool($data['isTimezoneBasedSchedule'] ?? null),
            timezoneBasedScheduleId: Cast::string($data['timezoneBasedScheduleId'] ?? null),
            scheduleIds: Cast::strings($data['scheduleIds'] ?? null),
            holidayCountries: Cast::strings($data['holidayCountries'] ?? null),
            sendingPattern: Cast::object($data['sendingPattern'] ?? null, CampaignSettingsScheduleSendingPatternDto::fromArray(...)),
            endDate: Cast::object($data['endDate'] ?? null, CampaignSettingsScheduleEndDateDto::fromArray(...)),
            raw: $data,
        );
    }
}
