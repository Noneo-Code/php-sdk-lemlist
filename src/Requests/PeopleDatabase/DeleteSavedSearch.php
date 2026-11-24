<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\PeopleDatabase;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete Saved Search — `DELETE /database/saved-searches/{savedSearchId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DeleteSavedSearch extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(private readonly string $savedSearchId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/database/saved-searches/'.rawurlencode($this->savedSearchId);
    }
}
