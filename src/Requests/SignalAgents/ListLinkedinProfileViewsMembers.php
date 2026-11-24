<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\SignalAgents;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List LinkedIn profile views members — `GET /watchlist/linkedin-profile-views/members`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListLinkedinProfileViewsMembers extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/watchlist/linkedin-profile-views/members';
    }
}
