<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Tasks;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List Task Filters — `GET /v2/tasks/filters`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListTaskFilters extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $scope = null,
        private readonly ?string $search = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/tasks/filters';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'scope' => $this->scope,
            'search' => $this->search,
        ]);
    }
}
