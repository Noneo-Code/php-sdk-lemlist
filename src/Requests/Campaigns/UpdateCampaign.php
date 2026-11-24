<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Campaigns;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update Campaign — `PATCH /campaigns/{campaignId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateCampaign extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param list<string>|null         $sendUserIds
     * @param list<string>|null         $autoReviewConditions
     * @param array<string, mixed>|null $aiFeatures
     * @param array<string, mixed>|null $tracking
     * @param array<string, mixed>|null $onReplied
     * @param array<string, mixed>|null $onLinkClicked
     * @param array<string, mixed>|null $onMeetingBooked
     */
    public function __construct(
        private readonly string $campaignId,
        private readonly ?string $name = null,
        private readonly ?string $emoji = null,
        private readonly ?bool $stopOnEmailReplied = null,
        private readonly ?bool $stopOnMeetingBooked = null,
        private readonly ?bool $stopOnLinkClicked = null,
        private readonly ?bool $leadsPausedByInterest = null,
        private readonly ?bool $opportunityReplied = null,
        private readonly ?bool $opportunityClicked = null,
        private readonly ?bool $autoLeadInterest = null,
        private readonly ?bool $disableTrackOpen = null,
        private readonly ?bool $disableTrackClick = null,
        private readonly ?bool $disableTrackReply = null,
        private readonly ?bool $disableOutOfOffice = null,
        private readonly ?bool $sequenceSharing = null,
        private readonly ?string $stopOnLinkClickedFilter = null,
        private readonly ?array $sendUserIds = null,
        private readonly ?bool $autoReview = null,
        private readonly ?array $autoReviewConditions = null,
        private readonly ?array $aiFeatures = null,
        private readonly ?array $tracking = null,
        private readonly ?array $onReplied = null,
        private readonly ?array $onLinkClicked = null,
        private readonly ?array $onMeetingBooked = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'emoji' => $this->emoji,
            'stopOnEmailReplied' => $this->stopOnEmailReplied,
            'stopOnMeetingBooked' => $this->stopOnMeetingBooked,
            'stopOnLinkClicked' => $this->stopOnLinkClicked,
            'leadsPausedByInterest' => $this->leadsPausedByInterest,
            'opportunityReplied' => $this->opportunityReplied,
            'opportunityClicked' => $this->opportunityClicked,
            'autoLeadInterest' => $this->autoLeadInterest,
            'disableTrackOpen' => $this->disableTrackOpen,
            'disableTrackClick' => $this->disableTrackClick,
            'disableTrackReply' => $this->disableTrackReply,
            'disableOutOfOffice' => $this->disableOutOfOffice,
            'sequenceSharing' => $this->sequenceSharing,
            'stopOnLinkClickedFilter' => $this->stopOnLinkClickedFilter,
            'sendUserIds' => $this->sendUserIds,
            'autoReview' => $this->autoReview,
            'autoReviewConditions' => $this->autoReviewConditions,
            'aiFeatures' => $this->aiFeatures,
            'tracking' => $this->tracking,
            'onReplied' => $this->onReplied,
            'onLinkClicked' => $this->onLinkClicked,
            'onMeetingBooked' => $this->onMeetingBooked,
        ]);
    }
}
