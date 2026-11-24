<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Warmup;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get warmup errors — `GET /warmup/errors`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetWarmupErrors extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/warmup/errors';
    }
}
