<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\SenderPicture;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Sync Sender Picture — `POST /sender-picture/sync`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class SyncSenderPicture extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly ?string $scope = null,
        private readonly ?string $mailboxId = null,
        private readonly ?string $email = null,
        private readonly ?string $userId = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/sender-picture/sync';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'scope' => $this->scope,
            'mailboxId' => $this->mailboxId,
            'email' => $this->email,
            'userId' => $this->userId,
        ]);
    }
}
