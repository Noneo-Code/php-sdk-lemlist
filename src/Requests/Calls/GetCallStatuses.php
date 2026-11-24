<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Calls;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Call Statuses — `GET /call-statuses`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetCallStatuses extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/call-statuses';
    }
}
