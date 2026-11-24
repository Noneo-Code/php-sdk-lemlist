<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\SignalAgents;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete Signal Agent — `DELETE /watchlist`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DeleteSignalAgent extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(private readonly string $watchListId)
    {
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
            'watchListId' => $this->watchListId,
        ]);
    }
}
