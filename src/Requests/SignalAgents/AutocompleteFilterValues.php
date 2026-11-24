<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\SignalAgents;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Autocomplete filter values — `GET /watchlist/filter-values`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class AutocompleteFilterValues extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $filterId,
        private readonly ?string $type = null,
        private readonly ?string $queryValue = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/watchlist/filter-values';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'filterId' => $this->filterId,
            'type' => $this->type,
            'query' => $this->queryValue,
        ]);
    }
}
