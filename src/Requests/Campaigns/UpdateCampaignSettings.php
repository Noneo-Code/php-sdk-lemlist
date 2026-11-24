<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Campaigns;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update Campaign Settings — `PATCH /campaigns/{campaignId}/settings`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateCampaignSettings extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param array<string, mixed>|null $general
     * @param array<string, mixed>|null $senders
     * @param array<string, mixed>|null $automation
     * @param array<string, mixed>|null $tracking
     * @param array<string, mixed>|null $onReplied
     * @param array<string, mixed>|null $onLinkClicked
     * @param array<string, mixed>|null $onMeetingBooked
     * @param array<string, mixed>|null $aiFeatures
     * @param array<string, mixed>|null $schedule
     */
    public function __construct(
        private readonly string $campaignId,
        private readonly ?string $senderStrategy = null,
        private readonly ?array $general = null,
        private readonly ?array $senders = null,
        private readonly ?array $automation = null,
        private readonly ?array $tracking = null,
        private readonly ?array $onReplied = null,
        private readonly ?array $onLinkClicked = null,
        private readonly ?array $onMeetingBooked = null,
        private readonly ?array $aiFeatures = null,
        private readonly ?array $schedule = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/settings';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'senderStrategy' => $this->senderStrategy,
            'general' => $this->general,
            'senders' => $this->senders,
            'automation' => $this->automation,
            'tracking' => $this->tracking,
            'onReplied' => $this->onReplied,
            'onLinkClicked' => $this->onLinkClicked,
            'onMeetingBooked' => $this->onMeetingBooked,
            'aiFeatures' => $this->aiFeatures,
            'schedule' => $this->schedule,
        ]);
    }
}
