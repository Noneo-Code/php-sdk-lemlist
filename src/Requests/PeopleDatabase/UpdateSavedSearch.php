<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\PeopleDatabase;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update Saved Search — `PATCH /database/saved-searches/{savedSearchId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateSavedSearch extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param list<array<string, mixed>>|null $filters
     */
    public function __construct(
        private readonly string $savedSearchId,
        private readonly ?string $name = null,
        private readonly ?array $filters = null,
        private readonly ?string $mode = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/database/saved-searches/'.rawurlencode($this->savedSearchId);
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
