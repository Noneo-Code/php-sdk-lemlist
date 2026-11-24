<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Calls\GetACall;
use Noneo\Sdk\Lemlist\Requests\Calls\GetCallStatuses;
use Noneo\Sdk\Lemlist\Requests\Calls\LogACall;
use Noneo\Sdk\Lemlist\Requests\Calls\UpdateACall;

/**
 * Section « Calls » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Calls
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Log a Call.
     *
     * `POST /calls`
     *
     * @param string                    $externalId   Your own id of the call, unique in your dialer
     * @param string                    $userId       The lemlist user who made or took the call (`usr_…`), a member of the team
     * @param string                    $direction    valeurs : inbound, outbound
     * @param \DateTimeInterface|string $startedAt    When the call started, ISO 8601
     * @param string|null               $from         The caller's number: the rep's line on an outbound call, the contact's number on an inbound one
     * @param string|null               $to           The number called: the contact's number on an outbound call, the rep's line on an inbound one, standardized like `from`
     * @param int|null                  $duration     Seconds
     * @param string|null               $callStatus   A key of the team's call statuses (`GET /call-statuses`)
     * @param string|null               $note         The rep's note on the call: shown with the call in lemlist and written in the CRM call note
     * @param string|null               $recordingUrl An `https` URL of the recording, reachable from the public internet
     * @param string|null               $transcript   The transcript as plain text
     * @param string|null               $provider     Your dialer's name, the same on every call you log
     * @param string|null               $taskId       A call task of a campaign (`opp_…`, from `GET /tasks`): the call completes it and the sequence moves on
     * @param string|null               $leadId       The lead the call was with (`lea_…`), with its campaign
     * @param string|null               $contactId    The contact the call was with (`ctc_…`)
     * @param string|null               $email        An email address of the contact the call was with
     * @param string|null               $phone        A phone number the call was with: the contact holding it in its phone field
     *
     * @return array<array-key, mixed>
     */
    public function logACall(
        string $externalId,
        string $userId,
        string $direction,
        \DateTimeInterface|string $startedAt,
        ?string $from = null,
        ?string $to = null,
        ?int $duration = null,
        ?string $callStatus = null,
        ?string $note = null,
        ?string $recordingUrl = null,
        ?string $transcript = null,
        ?string $provider = null,
        ?string $taskId = null,
        ?string $leadId = null,
        ?string $contactId = null,
        ?string $email = null,
        ?string $phone = null,
    ): array {
        $response = $this->connector->send(new LogACall(
            externalId: $externalId,
            userId: $userId,
            direction: $direction,
            startedAt: $startedAt,
            from: $from,
            to: $to,
            duration: $duration,
            callStatus: $callStatus,
            note: $note,
            recordingUrl: $recordingUrl,
            transcript: $transcript,
            provider: $provider,
            taskId: $taskId,
            leadId: $leadId,
            contactId: $contactId,
            email: $email,
            phone: $phone,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Get a Call.
     *
     * `GET /calls/{id}`
     *
     * @param string $id The call's `_id` (`act_…`) or its `externalId`
     *
     * @return array<array-key, mixed>
     */
    public function getACall(string $id): array
    {
        $response = $this->connector->send(new GetACall(id: $id));

        return ResponseDecoder::object($response);
    }

    /**
     * Update a Call.
     *
     * `PATCH /calls/{id}`
     *
     * @param string      $id           The call's `_id` (`act_…`) or its `externalId`
     * @param string|null $callStatus   A key of the team's call statuses (`GET /call-statuses`)
     * @param int|null    $duration     Seconds
     * @param string|null $recordingUrl An `https` URL of the recording, reachable from the public internet
     * @param string|null $transcript   The transcript as plain text
     *
     * @return array<array-key, mixed>
     */
    public function updateACall(
        string $id,
        ?string $callStatus = null,
        ?string $note = null,
        ?int $duration = null,
        ?string $recordingUrl = null,
        ?string $transcript = null,
    ): array {
        $response = $this->connector->send(new UpdateACall(
            id: $id,
            callStatus: $callStatus,
            note: $note,
            duration: $duration,
            recordingUrl: $recordingUrl,
            transcript: $transcript,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Call Statuses.
     *
     * `GET /call-statuses`
     *
     * @return array<array-key, mixed>
     */
    public function getCallStatuses(): array
    {
        $response = $this->connector->send(new GetCallStatuses());

        return ResponseDecoder::object($response);
    }
}
