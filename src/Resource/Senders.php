<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Senders\AddCampaignSenders;
use Noneo\Sdk\Lemlist\Requests\Senders\GetCampaignSenderExclusions;
use Noneo\Sdk\Lemlist\Requests\Senders\GetCampaignSenders;
use Noneo\Sdk\Lemlist\Requests\Senders\GetTeamSenderExclusions;
use Noneo\Sdk\Lemlist\Requests\Senders\ListSenders;
use Noneo\Sdk\Lemlist\Requests\Senders\RemoveCampaignSender;
use Noneo\Sdk\Lemlist\Requests\Senders\ReplaceCampaignSenderExclusions;
use Noneo\Sdk\Lemlist\Requests\Senders\ReplaceCampaignSenders;
use Noneo\Sdk\Lemlist\Requests\Senders\ReplaceTeamSenderExclusions;
use Noneo\Sdk\Lemlist\Requests\Senders\UpdateCampaignSenderChannels;

/**
 * Section « Senders » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Senders
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Get Team Sender Exclusions.
     *
     * `GET /team/dynamic-sender-exclusions`
     *
     * @return array<array-key, mixed>
     */
    public function getTeamSenderExclusions(): array
    {
        $response = $this->connector->send(new GetTeamSenderExclusions());

        return ResponseDecoder::object($response);
    }

    /**
     * Replace Team Sender Exclusions.
     *
     * `PUT /team/dynamic-sender-exclusions`
     *
     * @param list<array<string, mixed>> $senders The new list
     *
     * @return array<array-key, mixed>
     */
    public function replaceTeamSenderExclusions(array $senders): array
    {
        $response = $this->connector->send(new ReplaceTeamSenderExclusions(senders: $senders));

        return ResponseDecoder::object($response);
    }

    /**
     * List Senders.
     *
     * `GET /senders`
     *
     * @param string|null $campaignId Adds `inPool`, the sender strategy and the channel types that the campaign steps use
     *
     * @return array<array-key, mixed>
     */
    public function listSenders(?string $campaignId = null): array
    {
        $response = $this->connector->send(new ListSenders(campaignId: $campaignId));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Campaign Senders.
     *
     * `GET /campaigns/{campaignId}/senders`
     *
     * @param string $campaignId The unique identifier of the campaign
     *
     * @return array<array-key, mixed>
     */
    public function getCampaignSenders(string $campaignId): array
    {
        $response = $this->connector->send(new GetCampaignSenders(campaignId: $campaignId));

        return ResponseDecoder::object($response);
    }

    /**
     * Add Campaign Senders.
     *
     * `POST /campaigns/{campaignId}/senders`
     *
     * @param string                     $campaignId The unique identifier of the campaign
     * @param list<array<string, mixed>> $senders
     *
     * @return array<array-key, mixed>
     */
    public function addCampaignSenders(string $campaignId, array $senders): array
    {
        $response = $this->connector->send(new AddCampaignSenders(campaignId: $campaignId, senders: $senders));

        return ResponseDecoder::object($response);
    }

    /**
     * Replace Campaign Senders.
     *
     * `PUT /campaigns/{campaignId}/senders`
     *
     * @param string                     $campaignId The unique identifier of the campaign
     * @param list<array<string, mixed>> $senders
     *
     * @return array<array-key, mixed>
     */
    public function replaceCampaignSenders(string $campaignId, array $senders): array
    {
        $response = $this->connector->send(new ReplaceCampaignSenders(campaignId: $campaignId, senders: $senders));

        return ResponseDecoder::object($response);
    }

    /**
     * Update Campaign Sender Channels.
     *
     * `PATCH /campaigns/{campaignId}/senders/{userId}`
     *
     * @param string                     $campaignId The unique identifier of the campaign
     * @param string                     $userId     The team member to change
     * @param list<array<string, mixed>> $channels
     *
     * @return array<array-key, mixed>
     */
    public function updateCampaignSenderChannels(
        string $campaignId,
        string $userId,
        array $channels,
    ): array {
        $response = $this->connector->send(new UpdateCampaignSenderChannels(
            campaignId: $campaignId,
            userId: $userId,
            channels: $channels,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Remove Campaign Sender.
     *
     * `DELETE /campaigns/{campaignId}/senders/{userId}`
     *
     * @param string $campaignId The unique identifier of the campaign
     * @param string $userId     The team member to change
     *
     * @return array<array-key, mixed>
     */
    public function removeCampaignSender(string $campaignId, string $userId): array
    {
        $response = $this->connector->send(new RemoveCampaignSender(campaignId: $campaignId, userId: $userId));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Campaign Sender Exclusions.
     *
     * `GET /campaigns/{campaignId}/dynamic-sender-exclusions`
     *
     * @param string $campaignId The unique identifier of the campaign
     *
     * @return array<array-key, mixed>
     */
    public function getCampaignSenderExclusions(string $campaignId): array
    {
        $response = $this->connector->send(new GetCampaignSenderExclusions(campaignId: $campaignId));

        return ResponseDecoder::object($response);
    }

    /**
     * Replace Campaign Sender Exclusions.
     *
     * `PUT /campaigns/{campaignId}/dynamic-sender-exclusions`
     *
     * @param string                     $campaignId The unique identifier of the campaign
     * @param list<array<string, mixed>> $senders    The new campaign list
     *
     * @return array<array-key, mixed>
     */
    public function replaceCampaignSenderExclusions(string $campaignId, array $senders): array
    {
        $response = $this->connector->send(new ReplaceCampaignSenderExclusions(campaignId: $campaignId, senders: $senders));

        return ResponseDecoder::object($response);
    }
}
