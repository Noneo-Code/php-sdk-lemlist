<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\SignalAgents;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Signal Agent signals — `GET /watchlist/signals`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetSignalAgentSignals extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param string|list<string>|null $type
     * @param string|list<string>|null $status
     */
    public function __construct(
        private readonly ?int $page = null,
        private readonly ?int $limit = null,
        private readonly ?string $sortBy = null,
        private readonly ?string $sortOrder = null,
        private readonly string|array|null $type = null,
        private readonly string|array|null $status = null,
        private readonly \DateTimeInterface|string|null $receivedAtFrom = null,
        private readonly \DateTimeInterface|string|null $receivedAtTo = null,
        private readonly ?string $watchListId = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/watchlist/signals';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'page' => $this->page,
            'limit' => $this->limit,
            'sortBy' => $this->sortBy,
            'sortOrder' => $this->sortOrder,
            'type' => $this->type,
            'status' => $this->status,
            'receivedAtFrom' => $this->receivedAtFrom,
            'receivedAtTo' => $this->receivedAtTo,
            'watchListId' => $this->watchListId,
        ]);
    }
}
