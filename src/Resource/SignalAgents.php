<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\ExternalSignalPushResponseDto;
use Noneo\Sdk\Lemlist\Dto\LinkedinProfileViewsMembersResponseDto;
use Noneo\Sdk\Lemlist\Dto\WatchListApiDeleteWatchListResponseDto;
use Noneo\Sdk\Lemlist\Dto\WatchListApiFetchSignalsResponseDto;
use Noneo\Sdk\Lemlist\Dto\WatchListApiFiltersResponseDto;
use Noneo\Sdk\Lemlist\Dto\WatchListApiFilterValuesResponseDto;
use Noneo\Sdk\Lemlist\Dto\WatchListApiHistoryResponseDto;
use Noneo\Sdk\Lemlist\Dto\WatchListApiLibraryResponseDto;
use Noneo\Sdk\Lemlist\Dto\WatchListApiListWatchListsResponseDto;
use Noneo\Sdk\Lemlist\Dto\WatchListApiUpdateSignalStatusResponseDto;
use Noneo\Sdk\Lemlist\Dto\WatchListApiWatchListResponseDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\SignalAgents\AddSignalAgentTrigger;
use Noneo\Sdk\Lemlist\Requests\SignalAgents\AutocompleteFilterValues;
use Noneo\Sdk\Lemlist\Requests\SignalAgents\CreateSignalAgent;
use Noneo\Sdk\Lemlist\Requests\SignalAgents\DeleteSignalAgent;
use Noneo\Sdk\Lemlist\Requests\SignalAgents\GetSignalAgentConfigurationHistory;
use Noneo\Sdk\Lemlist\Requests\SignalAgents\GetSignalAgentSignals;
use Noneo\Sdk\Lemlist\Requests\SignalAgents\ListAllowedFiltersPerSignalType;
use Noneo\Sdk\Lemlist\Requests\SignalAgents\ListAvailableSignalTypes;
use Noneo\Sdk\Lemlist\Requests\SignalAgents\ListLinkedinProfileViewsMembers;
use Noneo\Sdk\Lemlist\Requests\SignalAgents\ListSignalAgents;
use Noneo\Sdk\Lemlist\Requests\SignalAgents\MarkSignalsHandledOrIgnored;
use Noneo\Sdk\Lemlist\Requests\SignalAgents\MonitorCrmListsWithASignalAgent;
use Noneo\Sdk\Lemlist\Requests\SignalAgents\PushExternalSignals;
use Noneo\Sdk\Lemlist\Requests\SignalAgents\RemoveSignalAgentTrigger;
use Noneo\Sdk\Lemlist\Requests\SignalAgents\UpdateSignalAgent;

/**
 * Section « SignalAgents » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class SignalAgents
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Add Signal Agent Trigger.
     *
     * `POST /campaigns/{campaignId}/triggers/watch-lists`
     *
     * @param string $campaignId  The unique identifier of the campaign
     * @param string $watchListId Id of the Signal Agent (wat_xxx) to link to the campaign
     *
     * @return array<array-key, mixed>
     */
    public function addSignalAgentTrigger(string $campaignId, string $watchListId): array
    {
        $response = $this->connector->send(new AddSignalAgentTrigger(campaignId: $campaignId, watchListId: $watchListId));

        return ResponseDecoder::object($response);
    }

    /**
     * Remove Signal Agent Trigger.
     *
     * `DELETE /campaigns/{campaignId}/triggers/watch-lists/{watchListId}`
     *
     * @param string $campaignId  The unique identifier of the campaign
     * @param string $watchListId Id of the Signal Agent (wat_xxx) to detach
     *
     * @return array<array-key, mixed>
     */
    public function removeSignalAgentTrigger(string $campaignId, string $watchListId): array
    {
        $response = $this->connector->send(new RemoveSignalAgentTrigger(campaignId: $campaignId, watchListId: $watchListId));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Signal Agent signals.
     *
     * `GET /watchlist/signals`
     *
     * @param int|null                       $page           Page number to retrieve
     * @param int|null                       $limit          Number of signals to retrieve
     * @param string|null                    $sortBy         The field by which to sort signals (valeurs : receivedAt, createdAt)
     * @param string|null                    $sortOrder      The sort direction (valeurs : asc, desc)
     * @param string|list<string>|null       $type           Filter by signal type(s)
     * @param string|list<string>|null       $status         Filter by signal status(es)
     * @param \DateTimeInterface|string|null $receivedAtFrom Filter signals received on or after this date (ISO date string)
     * @param \DateTimeInterface|string|null $receivedAtTo   Filter signals received on or before this date (ISO date string)
     * @param string|null                    $watchListId    Filter signals by specific Signal Agent ID
     */
    public function getSignalAgentSignals(
        ?int $page = null,
        ?int $limit = null,
        ?string $sortBy = null,
        ?string $sortOrder = null,
        string|array|null $type = null,
        string|array|null $status = null,
        \DateTimeInterface|string|null $receivedAtFrom = null,
        \DateTimeInterface|string|null $receivedAtTo = null,
        ?string $watchListId = null,
    ): WatchListApiFetchSignalsResponseDto {
        $response = $this->connector->send(new GetSignalAgentSignals(
            page: $page,
            limit: $limit,
            sortBy: $sortBy,
            sortOrder: $sortOrder,
            type: $type,
            status: $status,
            receivedAtFrom: $receivedAtFrom,
            receivedAtTo: $receivedAtTo,
            watchListId: $watchListId,
        ));

        return WatchListApiFetchSignalsResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Mark signals handled or ignored.
     *
     * `PUT /watchlist/signals`
     *
     * @param list<string> $signalIds Signal ids (wsi_xxx) to update, from List signals
     * @param string       $status    Target status to set on every signal (valeurs : handled, ignored)
     * @param string|null  $reason    Optional note explaining the decision
     */
    public function markSignalsHandledOrIgnored(
        array $signalIds,
        string $status,
        ?string $reason = null,
    ): WatchListApiUpdateSignalStatusResponseDto {
        $response = $this->connector->send(new MarkSignalsHandledOrIgnored(
            signalIds: $signalIds,
            status: $status,
            reason: $reason,
        ));

        return WatchListApiUpdateSignalStatusResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Push external signals.
     *
     * `POST /watchlist/{watchListId}/external-signals`
     *
     * @param string                    $watchListId  Id of the Signal Agent to push the signal to
     * @param array<string, mixed>|null $contact      The contact the signal is about
     * @param array<string, mixed>|null $company      The company the signal is about
     * @param array<string, mixed>|null $customFields Optional key/value metadata stored on the signal
     */
    public function pushExternalSignals(
        string $watchListId,
        ?array $contact = null,
        ?array $company = null,
        ?array $customFields = null,
    ): ExternalSignalPushResponseDto {
        $response = $this->connector->send(new PushExternalSignals(
            watchListId: $watchListId,
            contact: $contact,
            company: $company,
            customFields: $customFields,
        ));

        return ExternalSignalPushResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * List Signal Agents.
     *
     * `GET /watchlist`
     *
     * @param int|null    $page   Page number to retrieve
     * @param int|null    $limit  Number of records to retrieve
     * @param string|null $type   Filter by signal type(s)
     * @param string|null $status Filter by lifecycle status(es)
     */
    public function listSignalAgents(
        ?int $page = null,
        ?int $limit = null,
        ?string $type = null,
        ?string $status = null,
    ): WatchListApiListWatchListsResponseDto {
        $response = $this->connector->send(new ListSignalAgents(
            page: $page,
            limit: $limit,
            type: $type,
            status: $status,
        ));

        return WatchListApiListWatchListsResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Create Signal Agent.
     *
     * `POST /watchlist`
     *
     * @param string                          $name                      Display name
     * @param string                          $type                      Signal type to monitor
     * @param list<array<string, mixed>>|null $filters                   Filters to apply (validated against the signal type)
     * @param string|null                     $emoji                     Emoji shown next to the agent name (defaults to a random emoji)
     * @param string|null                     $segmentType               Entity sourcing (valeurs : all)
     * @param string|null                     $signalProcessingType      How detected signals are processed (valeurs : manual, create_opportunity, push_to_campaign)
     * @param array<string, mixed>|null       $signalOpportunityTemplate Task/opportunity template applied to each signal when signalProcessingType is create_opportunity
     * @param string|null                     $personaId                 Persona (pdp_xxx) used to source contacts from the People Database
     * @param string|null                     $campaignId                Campaign (cam_xxx) to link as this Signal Agent's signal trigger, in the same call: every new signal pushes its contact into that campaign as a lead
     * @param bool|null                       $activate                  Fully set up and activate the agent
     */
    public function createSignalAgent(
        string $name,
        string $type,
        ?array $filters = null,
        ?string $emoji = null,
        ?string $segmentType = null,
        ?string $signalProcessingType = null,
        ?array $signalOpportunityTemplate = null,
        ?string $personaId = null,
        ?string $campaignId = null,
        ?bool $activate = null,
    ): WatchListApiWatchListResponseDto {
        $response = $this->connector->send(new CreateSignalAgent(
            name: $name,
            type: $type,
            filters: $filters,
            emoji: $emoji,
            segmentType: $segmentType,
            signalProcessingType: $signalProcessingType,
            signalOpportunityTemplate: $signalOpportunityTemplate,
            personaId: $personaId,
            campaignId: $campaignId,
            activate: $activate,
        ));

        return WatchListApiWatchListResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Update Signal Agent.
     *
     * `PATCH /watchlist`
     *
     * @param string                          $watchListId          Signal Agent id to update
     * @param string|null                     $name                 New display name
     * @param list<array<string, mixed>>|null $filters              Replacement filters (validated against the agent's signal type)
     * @param string|null                     $emoji                New emoji
     * @param string|null                     $signalProcessingType New signal processing type (valeurs : manual, create_opportunity, push_to_campaign)
     * @param string|null                     $personaId            Persona (pdp_xxx) used to source contacts from the People Database
     * @param bool|null                       $activate             Toggle the agent status
     */
    public function updateSignalAgent(
        string $watchListId,
        ?string $name = null,
        ?array $filters = null,
        ?string $emoji = null,
        ?string $signalProcessingType = null,
        ?string $personaId = null,
        ?bool $activate = null,
    ): WatchListApiWatchListResponseDto {
        $response = $this->connector->send(new UpdateSignalAgent(
            watchListId: $watchListId,
            name: $name,
            filters: $filters,
            emoji: $emoji,
            signalProcessingType: $signalProcessingType,
            personaId: $personaId,
            activate: $activate,
        ));

        return WatchListApiWatchListResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Delete Signal Agent.
     *
     * `DELETE /watchlist`
     *
     * @param string $watchListId Signal Agent id to delete
     */
    public function deleteSignalAgent(string $watchListId): WatchListApiDeleteWatchListResponseDto
    {
        $response = $this->connector->send(new DeleteSignalAgent(watchListId: $watchListId));

        return WatchListApiDeleteWatchListResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Monitor CRM Lists with a Signal Agent.
     *
     * `POST /watchlist/crm-lists`
     *
     * @param string       $watchListId Signal Agent id (a draft, or an existing agent whose monitored lists are replaced)
     * @param list<string> $crmListIds  CRM list ids (clt_xxx)
     */
    public function monitorCrmListsWithASignalAgent(string $watchListId, array $crmListIds): WatchListApiWatchListResponseDto
    {
        $response = $this->connector->send(new MonitorCrmListsWithASignalAgent(watchListId: $watchListId, crmListIds: $crmListIds));

        return WatchListApiWatchListResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Get Signal Agent configuration history.
     *
     * `GET /watchlist/history`
     *
     * @param string   $watchListId Signal Agent id whose history to fetch
     * @param int|null $page        Page number to retrieve
     * @param int|null $limit       Number of records to retrieve
     */
    public function getSignalAgentConfigurationHistory(
        string $watchListId,
        ?int $page = null,
        ?int $limit = null,
    ): WatchListApiHistoryResponseDto {
        $response = $this->connector->send(new GetSignalAgentConfigurationHistory(
            watchListId: $watchListId,
            page: $page,
            limit: $limit,
        ));

        return WatchListApiHistoryResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * List available signal types.
     *
     * `GET /watchlist/library`
     */
    public function listAvailableSignalTypes(): WatchListApiLibraryResponseDto
    {
        $response = $this->connector->send(new ListAvailableSignalTypes());

        return WatchListApiLibraryResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * List allowed filters per signal type.
     *
     * `GET /watchlist/filters`
     *
     * @param string|null $type Restrict the response to a single signal type
     */
    public function listAllowedFiltersPerSignalType(?string $type = null): WatchListApiFiltersResponseDto
    {
        $response = $this->connector->send(new ListAllowedFiltersPerSignalType(type: $type));

        return WatchListApiFiltersResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * List LinkedIn profile views members.
     *
     * `GET /watchlist/linkedin-profile-views/members`
     */
    public function listLinkedinProfileViewsMembers(): LinkedinProfileViewsMembersResponseDto
    {
        $response = $this->connector->send(new ListLinkedinProfileViewsMembers());

        return LinkedinProfileViewsMembersResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Autocomplete filter values.
     *
     * `GET /watchlist/filter-values`
     *
     * @param string      $filterId Filter to resolve values for
     * @param string|null $type     Signal type the filter is resolved for
     * @param string|null $query    Search text, 3-100 characters
     */
    public function autocompleteFilterValues(
        string $filterId,
        ?string $type = null,
        ?string $query = null,
    ): WatchListApiFilterValuesResponseDto {
        $response = $this->connector->send(new AutocompleteFilterValues(
            filterId: $filterId,
            type: $type,
            queryValue: $query,
        ));

        return WatchListApiFilterValuesResponseDto::fromArray(ResponseDecoder::object($response));
    }
}
