<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\SignalAgents;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Signal Agent configuration history — `GET /watchlist/history`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetSignalAgentConfigurationHistory extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $watchListId,
        private readonly ?int $page = null,
        private readonly ?int $limit = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/watchlist/history';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'watchListId' => $this->watchListId,
            'page' => $this->page,
            'limit' => $this->limit,
        ]);
    }
}
