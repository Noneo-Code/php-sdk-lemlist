<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Domains;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List Domains — `GET /domains-core/team-domains`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListDomains extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/domains-core/team-domains';
    }
}
