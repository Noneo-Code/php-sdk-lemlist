<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `CampaignSettings` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class CampaignSettingsDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $campaignId = null,
        public ?string $timezone = null,
        public ?string $senderStrategy = null,
        public ?CampaignSettingsGeneralDto $general = null,
        public ?CampaignSettingsSendersDto $senders = null,
        public ?CampaignSettingsAutomationDto $automation = null,
        public ?CampaignSettingsTrackingDto $tracking = null,
        public ?CampaignSettingsOnRepliedDto $onReplied = null,
        public ?CampaignSettingsOnLinkClickedDto $onLinkClicked = null,
        public ?CampaignSettingsOnMeetingBookedDto $onMeetingBooked = null,
        public ?CampaignSettingsAiFeaturesDto $aiFeatures = null,
        public ?CampaignSettingsScheduleDto $schedule = null,
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
            campaignId: Cast::string($data['campaignId'] ?? null),
            timezone: Cast::string($data['timezone'] ?? null),
            senderStrategy: Cast::string($data['senderStrategy'] ?? null),
            general: Cast::object($data['general'] ?? null, CampaignSettingsGeneralDto::fromArray(...)),
            senders: Cast::object($data['senders'] ?? null, CampaignSettingsSendersDto::fromArray(...)),
            automation: Cast::object($data['automation'] ?? null, CampaignSettingsAutomationDto::fromArray(...)),
            tracking: Cast::object($data['tracking'] ?? null, CampaignSettingsTrackingDto::fromArray(...)),
            onReplied: Cast::object($data['onReplied'] ?? null, CampaignSettingsOnRepliedDto::fromArray(...)),
            onLinkClicked: Cast::object($data['onLinkClicked'] ?? null, CampaignSettingsOnLinkClickedDto::fromArray(...)),
            onMeetingBooked: Cast::object($data['onMeetingBooked'] ?? null, CampaignSettingsOnMeetingBookedDto::fromArray(...)),
            aiFeatures: Cast::object($data['aiFeatures'] ?? null, CampaignSettingsAiFeaturesDto::fromArray(...)),
            schedule: Cast::object($data['schedule'] ?? null, CampaignSettingsScheduleDto::fromArray(...)),
            raw: $data,
        );
    }
}
