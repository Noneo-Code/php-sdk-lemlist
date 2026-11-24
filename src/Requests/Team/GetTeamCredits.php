<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Team;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Team Credits — `GET /team/credits`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetTeamCredits extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/team/credits';
    }
}
