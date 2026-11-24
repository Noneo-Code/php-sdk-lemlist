<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Webhooks;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Many Webhooks — `GET /hooks`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetManyWebhooks extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/hooks';
    }
}
