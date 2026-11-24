<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\ActivityDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Activities\DeleteActivityRecordingTranscript;
use Noneo\Sdk\Lemlist\Requests\Activities\GetManyActivities;

/**
 * Section « Activities » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Activities
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Get Many Activities.
     *
     * `GET /activities`
     *
     * @param string      $version    API version (valeurs : v2)
     * @param string|null $type       Filter by activity type
     * @param string|null $campaignId Filter by campaign ID
     * @param bool|null   $isFirst    Filter for first activity
     * @param int|null    $offset     Number of records to skip
     * @param int|null    $limit      Number of activities to retrieve
     * @param string|null $leadId     Filter by lead ID
     * @param string|null $minDate    Filter activities by `createdAt >= minDate`
     * @param string|null $maxDate    Filter activities by `createdAt <= maxDate`
     * @param string|null $startDate  Alias for `minDate`, provided for consistency with sibling endpoints (e.g
     * @param string|null $endDate    Alias for `maxDate`, provided for consistency with sibling endpoints (e.g
     *
     * @return list<ActivityDto>
     */
    public function getManyActivities(
        string $version,
        ?string $type = null,
        ?string $campaignId = null,
        ?bool $isFirst = null,
        ?int $offset = null,
        ?int $limit = null,
        ?string $leadId = null,
        ?string $minDate = null,
        ?string $maxDate = null,
        ?string $startDate = null,
        ?string $endDate = null,
    ): array {
        $response = $this->connector->send(new GetManyActivities(
            version: $version,
            type: $type,
            campaignId: $campaignId,
            isFirst: $isFirst,
            offset: $offset,
            limit: $limit,
            leadId: $leadId,
            minDate: $minDate,
            maxDate: $maxDate,
            startDate: $startDate,
            endDate: $endDate,
        ));

        return array_map(ActivityDto::fromArray(...), ResponseDecoder::items($response));
    }

    /**
     * Delete Activity Recording & Transcript.
     *
     * `DELETE /activities/{activityId}/recording-transcript`
     *
     * @param string $activityId Unique activity ID
     *
     * @return array<array-key, mixed>
     */
    public function deleteActivityRecordingTranscript(string $activityId): array
    {
        $response = $this->connector->send(new DeleteActivityRecordingTranscript(activityId: $activityId));

        return ResponseDecoder::object($response);
    }
}
