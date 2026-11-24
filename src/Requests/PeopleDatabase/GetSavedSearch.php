<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\PeopleDatabase;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Saved Search — `GET /database/saved-searches/{savedSearchId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetSavedSearch extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $savedSearchId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/database/saved-searches/'.rawurlencode($this->savedSearchId);
    }
}
