<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\ScheduleDto;
use Noneo\Sdk\Lemlist\Dto\ScheduleListResponseDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Schedules\AssociateScheduleWithCampaign;
use Noneo\Sdk\Lemlist\Requests\Schedules\CreateSchedule;
use Noneo\Sdk\Lemlist\Requests\Schedules\DeleteSchedule;
use Noneo\Sdk\Lemlist\Requests\Schedules\GetCampaignSchedules;
use Noneo\Sdk\Lemlist\Requests\Schedules\GetManySchedules;
use Noneo\Sdk\Lemlist\Requests\Schedules\GetSchedule;
use Noneo\Sdk\Lemlist\Requests\Schedules\UpdateSchedule;

/**
 * Section « Schedules » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Schedules
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Get Many Schedules.
     *
     * `GET /schedules`
     *
     * @param int|null    $page      The page number to retrieve
     * @param int|null    $offset    The number of records to skip
     * @param int|null    $limit     The maximum number of records to return
     * @param string|null $sortBy    The field by which to sort the schedules (valeurs : createdAt)
     * @param string|null $sortOrder The sort direction (valeurs : asc, desc)
     */
    public function getManySchedules(
        ?int $page = null,
        ?int $offset = null,
        ?int $limit = null,
        ?string $sortBy = null,
        ?string $sortOrder = null,
    ): ScheduleListResponseDto {
        $response = $this->connector->send(new GetManySchedules(
            page: $page,
            offset: $offset,
            limit: $limit,
            sortBy: $sortBy,
            sortOrder: $sortOrder,
        ));

        return ScheduleListResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Create Schedule.
     *
     * `POST /schedules`
     *
     * @param string    $name          The name of the schedule
     * @param string    $timezone      Timezone for the schedule (e.g., 'Europe/Paris')
     * @param string    $start         Start time in HH:mm format
     * @param string    $end           End time in HH:mm format
     * @param list<int> $weekdays      Days of the week the schedule is active (1=Monday, 7=Sunday)
     * @param int|null  $secondsToWait Delay in seconds between operations
     * @param bool|null $public        Set to true to make the schedule visible to use as a template
     */
    public function createSchedule(
        string $name,
        string $timezone,
        string $start,
        string $end,
        array $weekdays,
        ?int $secondsToWait = null,
        ?bool $public = null,
    ): ScheduleDto {
        $response = $this->connector->send(new CreateSchedule(
            name: $name,
            timezone: $timezone,
            start: $start,
            end: $end,
            weekdays: $weekdays,
            secondsToWait: $secondsToWait,
            public: $public,
        ));

        return ScheduleDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Get Schedule.
     *
     * `GET /schedules/{scheduleId}`
     *
     * @param string $scheduleId The unique identifier of the schedule
     */
    public function getSchedule(string $scheduleId): ScheduleDto
    {
        $response = $this->connector->send(new GetSchedule(scheduleId: $scheduleId));

        return ScheduleDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Update Schedule.
     *
     * `PATCH /schedules/{scheduleId}`
     *
     * @param string         $scheduleId    The unique identifier of the schedule
     * @param string|null    $name          The name of the schedule
     * @param int|null       $secondsToWait Delay in seconds between operations
     * @param string|null    $timezone      Timezone for the schedule (e.g., 'Europe/Paris')
     * @param string|null    $start         Start time in HH:mm format
     * @param string|null    $end           End time in HH:mm format
     * @param list<int>|null $weekdays      Days of the week the schedule is active (1=Monday, 7=Sunday)
     * @param bool|null      $public        Set to true to make the schedule visible to use as a template
     */
    public function updateSchedule(
        string $scheduleId,
        ?string $name = null,
        ?int $secondsToWait = null,
        ?string $timezone = null,
        ?string $start = null,
        ?string $end = null,
        ?array $weekdays = null,
        ?bool $public = null,
    ): ScheduleDto {
        $response = $this->connector->send(new UpdateSchedule(
            scheduleId: $scheduleId,
            name: $name,
            secondsToWait: $secondsToWait,
            timezone: $timezone,
            start: $start,
            end: $end,
            weekdays: $weekdays,
            public: $public,
        ));

        return ScheduleDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Delete Schedule.
     *
     * `DELETE /schedules/{scheduleId}`
     *
     * @param string $scheduleId The unique identifier of the schedule
     *
     * @return array<array-key, mixed>
     */
    public function deleteSchedule(string $scheduleId): array
    {
        $response = $this->connector->send(new DeleteSchedule(scheduleId: $scheduleId));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Campaign Schedules.
     *
     * `GET /campaigns/{campaignId}/schedules/`
     *
     * @param string $campaignId The unique identifier of the campaign
     *
     * @return list<ScheduleDto>
     */
    public function getCampaignSchedules(string $campaignId): array
    {
        $response = $this->connector->send(new GetCampaignSchedules(campaignId: $campaignId));

        return array_map(ScheduleDto::fromArray(...), ResponseDecoder::items($response));
    }

    /**
     * Associate Schedule with Campaign.
     *
     * `POST /campaigns/{campaignId}/schedules/{scheduleId}`
     *
     * @param string $campaignId The unique identifier of the campaign
     * @param string $scheduleId The unique identifier of the schedule
     *
     * @return array<array-key, mixed>
     */
    public function associateScheduleWithCampaign(string $campaignId, string $scheduleId): array
    {
        $response = $this->connector->send(new AssociateScheduleWithCampaign(campaignId: $campaignId, scheduleId: $scheduleId));

        return ResponseDecoder::object($response);
    }
}
