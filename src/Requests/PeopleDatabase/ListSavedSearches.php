<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\PeopleDatabase;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List Saved Searches — `GET /database/saved-searches`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListSavedSearches extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly ?string $mode = null)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/database/saved-searches';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'mode' => $this->mode,
        ]);
    }
}
