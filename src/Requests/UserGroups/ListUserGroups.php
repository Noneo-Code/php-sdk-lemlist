<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\UserGroups;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List User Groups — `GET /v2/user-groups`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListUserGroups extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v2/user-groups';
    }
}
