<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Inbox;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Contact Messages — `GET /inbox/{contactId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetContactMessages extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $contactId,
        private readonly ?string $userId = null,
        private readonly ?int $limit = null,
        private readonly ?int $skip = null,
        private readonly ?bool $markAsRead = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/inbox/'.rawurlencode($this->contactId);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'userId' => $this->userId,
            'limit' => $this->limit,
            'skip' => $this->skip,
            'markAsRead' => $this->markAsRead,
        ]);
    }
}
