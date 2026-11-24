<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\SenderPicture;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Sender Picture Status — `GET /sender-picture/mailboxes`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetSenderPictureStatus extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly ?string $userId = null)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/sender-picture/mailboxes';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'userId' => $this->userId,
        ]);
    }
}
