<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Inbox;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Many Inboxes — `GET /inbox`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetManyInboxes extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $userId,
        private readonly ?int $page = null,
        private readonly ?int $limit = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/inbox';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'userId' => $this->userId,
            'page' => $this->page,
            'limit' => $this->limit,
        ]);
    }
}
