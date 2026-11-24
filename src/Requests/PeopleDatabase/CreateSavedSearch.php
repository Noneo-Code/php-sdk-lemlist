<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\PeopleDatabase;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create Saved Search — `POST /database/saved-searches`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class CreateSavedSearch extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<array<string, mixed>> $filters
     */
    public function __construct(
        private readonly string $name,
        private readonly array $filters,
        private readonly string $mode,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/database/saved-searches';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'filters' => $this->filters,
            'mode' => $this->mode,
        ]);
    }
}
