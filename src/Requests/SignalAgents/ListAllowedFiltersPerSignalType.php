<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\SignalAgents;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List allowed filters per signal type — `GET /watchlist/filters`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListAllowedFiltersPerSignalType extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly ?string $type = null)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/watchlist/filters';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'type' => $this->type,
        ]);
    }
}
