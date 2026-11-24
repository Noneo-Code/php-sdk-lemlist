<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\SenderPictureStatusResponseDto;
use Noneo\Sdk\Lemlist\Dto\SenderPictureSyncResponseDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\SenderPicture\GetSenderPictureStatus;
use Noneo\Sdk\Lemlist\Requests\SenderPicture\SyncSenderPicture;

/**
 * Section « SenderPicture » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class SenderPicture
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Get Sender Picture Status.
     *
     * `GET /sender-picture/mailboxes`
     *
     * @param string|null $userId A teammate whose mailboxes to read
     */
    public function getSenderPictureStatus(?string $userId = null): SenderPictureStatusResponseDto
    {
        $response = $this->connector->send(new GetSenderPictureStatus(userId: $userId));

        return SenderPictureStatusResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Sync Sender Picture.
     *
     * `POST /sender-picture/sync`
     *
     * @param string|null $scope     `not_synced`: every mailbox of the user that is not up to date; synced ones are left alone (valeurs : not_synced, all, mailbox)
     * @param string|null $mailboxId `scope=mailbox` only: the mailbox to push, as returned by Get Sender Picture Status
     * @param string|null $email     `scope=mailbox` only: the address of the mailbox to push, instead of `mailboxId`
     * @param string|null $userId    `scope=not_synced` or `scope=all` only: a teammate whose mailboxes to push
     */
    public function syncSenderPicture(
        ?string $scope = null,
        ?string $mailboxId = null,
        ?string $email = null,
        ?string $userId = null,
    ): SenderPictureSyncResponseDto {
        $response = $this->connector->send(new SyncSenderPicture(
            scope: $scope,
            mailboxId: $mailboxId,
            email: $email,
            userId: $userId,
        ));

        return SenderPictureSyncResponseDto::fromArray(ResponseDecoder::object($response));
    }
}
