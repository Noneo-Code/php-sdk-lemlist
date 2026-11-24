<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\SignalAgents;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List Signal Agents — `GET /watchlist`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListSignalAgents extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?int $page = null,
        private readonly ?int $limit = null,
        private readonly ?string $type = null,
        private readonly ?string $status = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/watchlist';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'page' => $this->page,
            'limit' => $this->limit,
            'type' => $this->type,
            'status' => $this->status,
        ]);
    }
}
