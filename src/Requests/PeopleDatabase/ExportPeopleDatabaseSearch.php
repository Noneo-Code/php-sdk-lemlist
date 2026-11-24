<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\PeopleDatabase;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Export People database search — `GET /database/people/export`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ExportPeopleDatabaseSearch extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $filters,
        private readonly ?int $limit = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/database/people/export';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'filters' => $this->filters,
            'limit' => $this->limit,
        ]);
    }
}
