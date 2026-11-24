<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\UserDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Users\GetSendingSettings;
use Noneo\Sdk\Lemlist\Requests\Users\GetUser;
use Noneo\Sdk\Lemlist\Requests\Users\GetUserChannels;
use Noneo\Sdk\Lemlist\Requests\Users\GetUserSignature;
use Noneo\Sdk\Lemlist\Requests\Users\UpdateSendingSettings;
use Noneo\Sdk\Lemlist\Requests\Users\UpdateUserLinkedInLimits;
use Noneo\Sdk\Lemlist\Requests\Users\UpdateUserSignature;

/**
 * Section « Users » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Users
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Get User.
     *
     * `GET /users/{userId}`
     *
     * @param string $userId The unique identifier of the user
     */
    public function getUser(string $userId): UserDto
    {
        $response = $this->connector->send(new GetUser(userId: $userId));

        return UserDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Get User Channels.
     *
     * `GET /user/channels`
     *
     * @return array<array-key, mixed>
     */
    public function getUserChannels(): array
    {
        $response = $this->connector->send(new GetUserChannels());

        return ResponseDecoder::object($response);
    }

    /**
     * Get Sending Settings.
     *
     * `GET /user/sending-settings`
     *
     * @param string|null $scope Set to `team` to list the email accounts of every current team member instead of the authenticated user's only (valeurs : team)
     *
     * @return array<array-key, mixed>
     */
    public function getSendingSettings(?string $scope = null): array
    {
        $response = $this->connector->send(new GetSendingSettings(scope: $scope));

        return ResponseDecoder::object($response);
    }

    /**
     * Update Sending Settings.
     *
     * `PATCH /user/sending-settings`
     *
     * @param list<array<string, mixed>> $emailAccounts
     *
     * @return array<array-key, mixed>
     */
    public function updateSendingSettings(array $emailAccounts): array
    {
        $response = $this->connector->send(new UpdateSendingSettings(emailAccounts: $emailAccounts));

        return ResponseDecoder::object($response);
    }

    /**
     * Update User LinkedIn Limits.
     *
     * `PATCH /users/{userId}/linkedin-limits`
     *
     * @param string   $userId                       ID of the team member whose LinkedIn limits to update (usr_xxx)
     * @param int|null $followLimit                  Max LinkedIn follows per day
     * @param int|null $inviteLimit                  Max LinkedIn invitations per day
     * @param int|null $sendLimit                    Max LinkedIn direct messages per day
     * @param int|null $visitLimit                   Max LinkedIn profile visits per day
     * @param int|null $inMailLimit                  Max LinkedIn InMails per day: a daily throttle, the monthly InMail credits of the LinkedIn plan stay the hard cap
     * @param int|null $networkCheckLimit            Max LinkedIn network checks per day
     * @param int|null $withdrawInvitationLimit      Max LinkedIn invitation withdrawals per day
     * @param int|null $likeLastPostLimit            Max LinkedIn last-post likes per day
     * @param int|null $endorseLimit                 Max LinkedIn endorsements per day
     * @param int|null $commentLastPostRetrieveLimit Max LinkedIn last-post retrievals per day
     * @param int|null $commentLastPostSendLimit     Max LinkedIn last-post comments per day
     * @param int|null $inviteRampUp                 Invite ramp-up: how much the daily invitation limit grows each day until it reaches inviteLimit
     *
     * @return array<array-key, mixed>
     */
    public function updateUserLinkedInLimits(
        string $userId,
        ?int $followLimit = null,
        ?int $inviteLimit = null,
        ?int $sendLimit = null,
        ?int $visitLimit = null,
        ?int $inMailLimit = null,
        ?int $networkCheckLimit = null,
        ?int $withdrawInvitationLimit = null,
        ?int $likeLastPostLimit = null,
        ?int $endorseLimit = null,
        ?int $commentLastPostRetrieveLimit = null,
        ?int $commentLastPostSendLimit = null,
        ?int $inviteRampUp = null,
    ): array {
        $response = $this->connector->send(new UpdateUserLinkedInLimits(
            userId: $userId,
            followLimit: $followLimit,
            inviteLimit: $inviteLimit,
            sendLimit: $sendLimit,
            visitLimit: $visitLimit,
            inMailLimit: $inMailLimit,
            networkCheckLimit: $networkCheckLimit,
            withdrawInvitationLimit: $withdrawInvitationLimit,
            likeLastPostLimit: $likeLastPostLimit,
            endorseLimit: $endorseLimit,
            commentLastPostRetrieveLimit: $commentLastPostRetrieveLimit,
            commentLastPostSendLimit: $commentLastPostSendLimit,
            inviteRampUp: $inviteRampUp,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Get User Signature.
     *
     * `GET /users/{userId}/signature`
     *
     * @param string $userId ID of the team member whose signatures to read (usr_xxx)
     *
     * @return array<array-key, mixed>
     */
    public function getUserSignature(string $userId): array
    {
        $response = $this->connector->send(new GetUserSignature(userId: $userId));

        return ResponseDecoder::object($response);
    }

    /**
     * Update User Signature.
     *
     * `PATCH /users/{userId}/signature`
     *
     * @param string      $userId             ID of the team member whose signatures to update (usr_xxx): yourself, or any other member of your team when the user the API key acts as is a team admin
     * @param string|null $signature          HTML signature, inserted by {{signature}} in emails sent as HTML
     * @param string|null $plainTextSignature Plain-text signature, inserted by {{plainTextSignature}} in emails sent as plain text and in lemwarm
     *
     * @return array<array-key, mixed>
     */
    public function updateUserSignature(
        string $userId,
        ?string $signature = null,
        ?string $plainTextSignature = null,
    ): array {
        $response = $this->connector->send(new UpdateUserSignature(
            userId: $userId,
            signature: $signature,
            plainTextSignature: $plainTextSignature,
        ));

        return ResponseDecoder::object($response);
    }
}
