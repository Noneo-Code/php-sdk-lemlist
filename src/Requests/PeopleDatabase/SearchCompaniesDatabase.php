<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\PeopleDatabase;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Search Companies Database — `POST /database/companies`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class SearchCompaniesDatabase extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<array<string, mixed>>|null $filters
     */
    public function __construct(
        private readonly ?array $filters = null,
        private readonly ?string $fromSearchId = null,
        private readonly ?int $page = null,
        private readonly ?int $size = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/database/companies';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'filters' => $this->filters,
            'fromSearchId' => $this->fromSearchId,
            'page' => $this->page,
            'size' => $this->size,
        ]);
    }
}
