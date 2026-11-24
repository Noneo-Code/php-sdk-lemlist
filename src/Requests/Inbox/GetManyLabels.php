<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Inbox;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Many Labels — `GET /inbox/labels`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetManyLabels extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/inbox/labels';
    }
}
