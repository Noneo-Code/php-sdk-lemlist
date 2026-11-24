<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\SignalAgents;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List available signal types — `GET /watchlist/library`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListAvailableSignalTypes extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/watchlist/library';
    }
}
