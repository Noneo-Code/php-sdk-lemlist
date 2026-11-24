<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\CampaignDto;
use Noneo\Sdk\Lemlist\Dto\CampaignSettingsDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Campaigns\AddAbmCampaignLeads;
use Noneo\Sdk\Lemlist\Requests\Campaigns\ArchiveCampaign;
use Noneo\Sdk\Lemlist\Requests\Campaigns\CreateCampaign;
use Noneo\Sdk\Lemlist\Requests\Campaigns\DuplicateCampaign;
use Noneo\Sdk\Lemlist\Requests\Campaigns\ExportCampaignLeads;
use Noneo\Sdk\Lemlist\Requests\Campaigns\GetBatchCampaignStats;
use Noneo\Sdk\Lemlist\Requests\Campaigns\GetCampaign;
use Noneo\Sdk\Lemlist\Requests\Campaigns\GetCampaignExportStatus;
use Noneo\Sdk\Lemlist\Requests\Campaigns\GetCampaignReports;
use Noneo\Sdk\Lemlist\Requests\Campaigns\GetCampaignSettings;
use Noneo\Sdk\Lemlist\Requests\Campaigns\GetCampaignStats;
use Noneo\Sdk\Lemlist\Requests\Campaigns\GetCampaignStatutes;
use Noneo\Sdk\Lemlist\Requests\Campaigns\GetManyCampaigns;
use Noneo\Sdk\Lemlist\Requests\Campaigns\PauseCampaign;
use Noneo\Sdk\Lemlist\Requests\Campaigns\SetEmailForCampaignExportNotification;
use Noneo\Sdk\Lemlist\Requests\Campaigns\SkipStepForEveryone;
use Noneo\Sdk\Lemlist\Requests\Campaigns\SkipStepForLeads;
use Noneo\Sdk\Lemlist\Requests\Campaigns\StartCampaign;
use Noneo\Sdk\Lemlist\Requests\Campaigns\StartCampaignStatsExport;
use Noneo\Sdk\Lemlist\Requests\Campaigns\UnarchiveCampaign;
use Noneo\Sdk\Lemlist\Requests\Campaigns\UpdateCampaign;
use Noneo\Sdk\Lemlist\Requests\Campaigns\UpdateCampaignSettings;

/**
 * Section « Campaigns » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Campaigns
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Get Many Campaigns.
     *
     * `GET /campaigns`
     *
     * @param int|null    $offset    Offset from the start
     * @param int|null    $limit     Number of campaigns to retrieve
     * @param string|null $version   Set to 'v2' to use the latest version (valeurs : v2)
     * @param int|null    $page      Page number to retrieve
     * @param string|null $sortBy    The field by which to sort (valeurs : createdAt)
     * @param string|null $sortOrder The sort direction (valeurs : asc, desc)
     * @param string|null $status    The campaign status (valeurs : running, draft, archived, ended, paused, errors)
     * @param string|null $createdBy Filter campaigns by creator user ID (usr_xxx format)
     * @param string|null $folderId  Filter campaigns by campaign folder
     *
     * @return list<CampaignDto>
     */
    public function getManyCampaigns(
        ?int $offset = null,
        ?int $limit = null,
        ?string $version = null,
        ?int $page = null,
        ?string $sortBy = null,
        ?string $sortOrder = null,
        ?string $status = null,
        ?string $createdBy = null,
        ?string $folderId = null,
    ): array {
        $response = $this->connector->send(new GetManyCampaigns(
            offset: $offset,
            limit: $limit,
            version: $version,
            page: $page,
            sortBy: $sortBy,
            sortOrder: $sortOrder,
            status: $status,
            createdBy: $createdBy,
            folderId: $folderId,
        ));

        return array_map(CampaignDto::fromArray(...), ResponseDecoder::items($response));
    }

    /**
     * Create Campaign.
     *
     * `POST /campaigns`
     *
     * @param string            $name                 The name of the campaign
     * @param string|null       $timezone             IANA timezone for the campaign schedule (e.g
     * @param string|null       $emoji                Emoji shown next to the campaign name (e.g
     * @param bool|null         $autoReview           Automatically launch (review) leads as soon as they are added to the campaign, instead of requiring manual review
     * @param list<string>|null $autoReviewConditions Email deliverability statuses for which a lead is auto-launched when `autoReview` is enabled
     *
     * @return array<array-key, mixed>
     */
    public function createCampaign(
        string $name,
        ?string $timezone = null,
        ?string $emoji = null,
        ?bool $autoReview = null,
        ?array $autoReviewConditions = null,
    ): array {
        $response = $this->connector->send(new CreateCampaign(
            name: $name,
            timezone: $timezone,
            emoji: $emoji,
            autoReview: $autoReview,
            autoReviewConditions: $autoReviewConditions,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Campaign.
     *
     * `GET /campaigns/{campaignId}`
     *
     * @param string $campaignId The unique identifier of the campaign
     */
    public function getCampaign(string $campaignId): CampaignDto
    {
        $response = $this->connector->send(new GetCampaign(campaignId: $campaignId));

        return CampaignDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Update Campaign.
     *
     * `PATCH /campaigns/{campaignId}`
     *
     * @param string                    $campaignId              The unique identifier of the campaign
     * @param string|null               $name                    The campaign name
     * @param string|null               $emoji                   Emoji shown next to the campaign name (e.g
     * @param bool|null                 $stopOnEmailReplied      Stop the campaign when a lead replies by email
     * @param bool|null                 $stopOnMeetingBooked     Stop the campaign when a meeting is booked
     * @param bool|null                 $stopOnLinkClicked       Stop the campaign when a link is clicked
     * @param bool|null                 $leadsPausedByInterest   Pause leads based on interest
     * @param bool|null                 $opportunityReplied      Create an opportunity when a lead replies
     * @param bool|null                 $opportunityClicked      Create an opportunity when a lead clicks a link
     * @param bool|null                 $autoLeadInterest        Automatically detect lead interest
     * @param bool|null                 $disableTrackOpen        Disable tracking of email opens
     * @param bool|null                 $disableTrackClick       Disable tracking of link clicks
     * @param bool|null                 $disableTrackReply       Disable tracking of email replies
     * @param bool|null                 $disableOutOfOffice      Disable out-of-office detection
     * @param bool|null                 $sequenceSharing         Enable sequence sharing for the campaign
     * @param string|null               $stopOnLinkClickedFilter Filter for which link clicks should stop the campaign
     * @param list<string>|null         $sendUserIds             Array of user IDs (usr_xxx format) to assign as campaign senders
     * @param bool|null                 $autoReview              Automatically launch (review) leads as soon as they are added to the campaign, instead of requiring manual review
     * @param list<string>|null         $autoReviewConditions    Email deliverability statuses for which a lead is auto-launched when `autoReview` is enabled
     * @param array<string, mixed>|null $aiFeatures              AI reply-handling settings
     * @param array<string, mixed>|null $tracking                Open / click / reply tracking toggles
     * @param array<string, mixed>|null $onReplied               Behavior when a lead replies
     * @param array<string, mixed>|null $onLinkClicked           Behavior when a lead clicks a tracked link
     * @param array<string, mixed>|null $onMeetingBooked         Behavior when a meeting is booked
     *
     * @return array<array-key, mixed>
     */
    public function updateCampaign(
        string $campaignId,
        ?string $name = null,
        ?string $emoji = null,
        ?bool $stopOnEmailReplied = null,
        ?bool $stopOnMeetingBooked = null,
        ?bool $stopOnLinkClicked = null,
        ?bool $leadsPausedByInterest = null,
        ?bool $opportunityReplied = null,
        ?bool $opportunityClicked = null,
        ?bool $autoLeadInterest = null,
        ?bool $disableTrackOpen = null,
        ?bool $disableTrackClick = null,
        ?bool $disableTrackReply = null,
        ?bool $disableOutOfOffice = null,
        ?bool $sequenceSharing = null,
        ?string $stopOnLinkClickedFilter = null,
        ?array $sendUserIds = null,
        ?bool $autoReview = null,
        ?array $autoReviewConditions = null,
        ?array $aiFeatures = null,
        ?array $tracking = null,
        ?array $onReplied = null,
        ?array $onLinkClicked = null,
        ?array $onMeetingBooked = null,
    ): array {
        $response = $this->connector->send(new UpdateCampaign(
            campaignId: $campaignId,
            name: $name,
            emoji: $emoji,
            stopOnEmailReplied: $stopOnEmailReplied,
            stopOnMeetingBooked: $stopOnMeetingBooked,
            stopOnLinkClicked: $stopOnLinkClicked,
            leadsPausedByInterest: $leadsPausedByInterest,
            opportunityReplied: $opportunityReplied,
            opportunityClicked: $opportunityClicked,
            autoLeadInterest: $autoLeadInterest,
            disableTrackOpen: $disableTrackOpen,
            disableTrackClick: $disableTrackClick,
            disableTrackReply: $disableTrackReply,
            disableOutOfOffice: $disableOutOfOffice,
            sequenceSharing: $sequenceSharing,
            stopOnLinkClickedFilter: $stopOnLinkClickedFilter,
            sendUserIds: $sendUserIds,
            autoReview: $autoReview,
            autoReviewConditions: $autoReviewConditions,
            aiFeatures: $aiFeatures,
            tracking: $tracking,
            onReplied: $onReplied,
            onLinkClicked: $onLinkClicked,
            onMeetingBooked: $onMeetingBooked,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Campaign Settings.
     *
     * `GET /campaigns/{campaignId}/settings`
     *
     * @param string $campaignId The unique identifier of the campaign
     */
    public function getCampaignSettings(string $campaignId): CampaignSettingsDto
    {
        $response = $this->connector->send(new GetCampaignSettings(campaignId: $campaignId));

        return CampaignSettingsDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Update Campaign Settings.
     *
     * `PATCH /campaigns/{campaignId}/settings`
     *
     * @param string                    $campaignId      The unique identifier of the campaign
     * @param string|null               $senderStrategy  How the campaign picks the sender of each lead: `random` (the sender pool), `contactOwner`, `leadImporter` or `customField:<fieldName>`
     * @param array<string, mixed>|null $general         Sequence sharing and unsubscribe link
     * @param array<string, mixed>|null $senders         Sender matching
     * @param array<string, mixed>|null $automation      Auto-review
     * @param array<string, mixed>|null $tracking        Open, click and reply tracking
     * @param array<string, mixed>|null $onReplied       What happens when a lead replies
     * @param array<string, mixed>|null $onLinkClicked   What happens when a lead clicks a tracked link
     * @param array<string, mixed>|null $onMeetingBooked What happens when a lead books a meeting
     * @param array<string, mixed>|null $aiFeatures      AI reply handling
     * @param array<string, mixed>|null $schedule        Sending schedule options
     */
    public function updateCampaignSettings(
        string $campaignId,
        ?string $senderStrategy = null,
        ?array $general = null,
        ?array $senders = null,
        ?array $automation = null,
        ?array $tracking = null,
        ?array $onReplied = null,
        ?array $onLinkClicked = null,
        ?array $onMeetingBooked = null,
        ?array $aiFeatures = null,
        ?array $schedule = null,
    ): CampaignSettingsDto {
        $response = $this->connector->send(new UpdateCampaignSettings(
            campaignId: $campaignId,
            senderStrategy: $senderStrategy,
            general: $general,
            senders: $senders,
            automation: $automation,
            tracking: $tracking,
            onReplied: $onReplied,
            onLinkClicked: $onLinkClicked,
            onMeetingBooked: $onMeetingBooked,
            aiFeatures: $aiFeatures,
            schedule: $schedule,
        ));

        return CampaignSettingsDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Pause Campaign.
     *
     * `POST /campaigns/{campaignId}/pause`
     *
     * @param string $campaignId The unique identifier of the campaign
     *
     * @return array<array-key, mixed>
     */
    public function pauseCampaign(string $campaignId): array
    {
        $response = $this->connector->send(new PauseCampaign(campaignId: $campaignId));

        return ResponseDecoder::object($response);
    }

    /**
     * Archive Campaign.
     *
     * `POST /campaigns/{campaignId}/archive`
     *
     * @param string $campaignId The unique identifier of the campaign
     *
     * @return array<array-key, mixed>
     */
    public function archiveCampaign(string $campaignId): array
    {
        $response = $this->connector->send(new ArchiveCampaign(campaignId: $campaignId));

        return ResponseDecoder::object($response);
    }

    /**
     * Unarchive Campaign.
     *
     * `POST /campaigns/{campaignId}/unarchive`
     *
     * @param string $campaignId The unique identifier of the campaign
     *
     * @return array<array-key, mixed>
     */
    public function unarchiveCampaign(string $campaignId): array
    {
        $response = $this->connector->send(new UnarchiveCampaign(campaignId: $campaignId));

        return ResponseDecoder::object($response);
    }

    /**
     * Skip Step for Everyone.
     *
     * `POST /campaigns/{campaignId}/steps/{stepId}/skip`
     *
     * @param string $campaignId The unique identifier of the campaign
     * @param string $stepId     The unique identifier of the step, from GET /campaigns/{campaignId}/sequences
     *
     * @return array<array-key, mixed>
     */
    public function skipStepForEveryone(string $campaignId, string $stepId): array
    {
        $response = $this->connector->send(new SkipStepForEveryone(campaignId: $campaignId, stepId: $stepId));

        return ResponseDecoder::object($response);
    }

    /**
     * Add ABM Campaign Leads.
     *
     * `POST /campaigns/{campaignId}/abm-leads`
     *
     * @param string       $campaignId The ABM campaign, opened with Engage on a company
     * @param list<string> $leadIds    People Database ids, from People Database search results or a contact-sourcing run's `contacts[].leadId`
     */
    public function addAbmCampaignLeads(string $campaignId, array $leadIds): mixed
    {
        $response = $this->connector->send(new AddAbmCampaignLeads(campaignId: $campaignId, leadIds: $leadIds));

        return ResponseDecoder::value($response);
    }

    /**
     * Skip Step for Leads.
     *
     * `POST /campaigns/{campaignId}/steps/{stepId}/skip-for-leads`
     *
     * @param string       $campaignId The unique identifier of the campaign
     * @param string       $stepId     The unique identifier of the step, from GET /campaigns/{campaignId}/sequences
     * @param list<string> $leads      The leads to skip the step for: 1 to 100 items
     *
     * @return array<array-key, mixed>
     */
    public function skipStepForLeads(
        string $campaignId,
        string $stepId,
        array $leads,
    ): array {
        $response = $this->connector->send(new SkipStepForLeads(
            campaignId: $campaignId,
            stepId: $stepId,
            leads: $leads,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Start Campaign.
     *
     * `POST /campaigns/{campaignId}/start`
     *
     * @param string $campaignId The unique identifier of the campaign
     *
     * @return array<array-key, mixed>
     */
    public function startCampaign(string $campaignId): array
    {
        $response = $this->connector->send(new StartCampaign(campaignId: $campaignId));

        return ResponseDecoder::object($response);
    }

    /**
     * Start Campaign Stats Export.
     *
     * `GET /campaigns/{campaignId}/export/start`
     *
     * @param string $campaignId The unique identifier of the campaign to export
     *
     * @return array<array-key, mixed>
     */
    public function startCampaignStatsExport(string $campaignId): array
    {
        $response = $this->connector->send(new StartCampaignStatsExport(campaignId: $campaignId));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Campaign Export Status.
     *
     * `GET /campaigns/{campaignId}/export/{exportId}/status`
     *
     * @param string $campaignId The unique identifier of the campaign that was exported
     * @param string $exportId   The unique identifier of the export returned by the /start endpoint
     *
     * @return array<array-key, mixed>
     */
    public function getCampaignExportStatus(string $campaignId, string $exportId): array
    {
        $response = $this->connector->send(new GetCampaignExportStatus(campaignId: $campaignId, exportId: $exportId));

        return ResponseDecoder::object($response);
    }

    /**
     * Set Email for Campaign Export Notification.
     *
     * `PUT /campaigns/{campaignId}/export/{exportId}/email/{email}`
     *
     * @param string $campaignId The unique identifier of the campaign that was exported
     * @param string $exportId   The unique identifier of the export returned by the /start endpoint
     * @param string $email      The email address to send the export URL to when the export is done
     *
     * @return array<array-key, mixed>
     */
    public function setEmailForCampaignExportNotification(
        string $campaignId,
        string $exportId,
        string $email,
    ): array {
        $response = $this->connector->send(new SetEmailForCampaignExportNotification(
            campaignId: $campaignId,
            exportId: $exportId,
            email: $email,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Export Campaign Leads.
     *
     * `GET /v2/campaigns/{campaignId}/export/leads`
     *
     * @param string      $campaignId The unique identifier of the campaign
     * @param string|null $state      Filter to export only the specified lead's last states
     * @param string|null $format     Output format: 'json' or 'csv' (valeurs : json, csv)
     */
    public function exportCampaignLeads(
        string $campaignId,
        ?string $state = null,
        ?string $format = null,
    ): mixed {
        $response = $this->connector->send(new ExportCampaignLeads(
            campaignId: $campaignId,
            state: $state,
            format: $format,
        ));

        return ResponseDecoder::value($response);
    }

    /**
     * Get Campaign Reports.
     *
     * `GET /campaigns/reports`
     *
     * @param string $campaignIds Comma-separated list of campaign IDs to retrieve reports for
     *
     * @return array<array-key, mixed>
     */
    public function getCampaignReports(string $campaignIds): array
    {
        $response = $this->connector->send(new GetCampaignReports(campaignIds: $campaignIds));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Campaign Stats.
     *
     * `GET /v2/campaigns/{campaignId}/stats`
     *
     * @param string                    $campaignId Unique campaign ID
     * @param \DateTimeInterface|string $startDate  Start date in ISO 8601 format
     * @param \DateTimeInterface|string $endDate    End date in ISO 8601 format
     * @param string|null               $sendUser   Filter stats by send user
     * @param string|null               $ABSelected A/B version filter (valeurs : A, B)
     * @param string|null               $channels   JSON array of channels to include
     *
     * @return array<array-key, mixed>
     */
    public function getCampaignStats(
        string $campaignId,
        \DateTimeInterface|string $startDate,
        \DateTimeInterface|string $endDate,
        ?string $sendUser = null,
        ?string $ABSelected = null,
        ?string $channels = null,
    ): array {
        $response = $this->connector->send(new GetCampaignStats(
            campaignId: $campaignId,
            startDate: $startDate,
            endDate: $endDate,
            sendUser: $sendUser,
            ABSelected: $ABSelected,
            channels: $channels,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Batch Campaign Stats.
     *
     * `POST /v2/campaigns/stats/batch`
     *
     * @param list<string>      $campaignIds Array of campaign IDs to retrieve stats for
     * @param string            $startDate   Start date in ISO 8601 format
     * @param string            $endDate     End date in ISO 8601 format
     * @param string|null       $sendUser    Filter stats by send user
     * @param string|null       $ABSelected  A/B version filter (valeurs : A, B)
     * @param list<string>|null $channels    Filter by communication channels
     *
     * @return array<array-key, mixed>
     */
    public function getBatchCampaignStats(
        array $campaignIds,
        string $startDate,
        string $endDate,
        ?string $sendUser = null,
        ?string $ABSelected = null,
        ?array $channels = null,
    ): array {
        $response = $this->connector->send(new GetBatchCampaignStats(
            campaignIds: $campaignIds,
            startDate: $startDate,
            endDate: $endDate,
            sendUser: $sendUser,
            ABSelected: $ABSelected,
            channels: $channels,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Duplicate Campaign.
     *
     * `POST /campaigns/{campaignId}/duplicate`
     *
     * @param string      $campaignId The unique identifier of the campaign to duplicate
     * @param string|null $name       Custom name for the duplicated campaign
     *
     * @return array<array-key, mixed>
     */
    public function duplicateCampaign(string $campaignId, ?string $name = null): array
    {
        $response = $this->connector->send(new DuplicateCampaign(campaignId: $campaignId, name: $name));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Campaign Statutes.
     *
     * `GET /campaigns/{campaignId}/statutes`
     *
     * @param string $campaignId The unique identifier of the campaign
     *
     * @return array<array-key, mixed>
     */
    public function getCampaignStatutes(string $campaignId): array
    {
        $response = $this->connector->send(new GetCampaignStatutes(campaignId: $campaignId));

        return ResponseDecoder::object($response);
    }
}
