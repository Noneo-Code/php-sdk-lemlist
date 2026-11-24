<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get User Channels — `GET /user/channels`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetUserChannels extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/user/channels';
    }
}
