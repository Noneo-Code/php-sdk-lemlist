<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\PeopleDatabase;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Search People Database — `POST /database/people`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class SearchPeopleDatabase extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<array<string, mixed>>|null $filters
     * @param list<string>|null               $excludes
     */
    public function __construct(
        private readonly ?array $filters = null,
        private readonly ?string $fromSearchId = null,
        private readonly ?int $page = null,
        private readonly ?int $size = null,
        private readonly ?array $excludes = null,
        private readonly ?string $search = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/database/people';
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
            'excludes' => $this->excludes,
            'search' => $this->search,
        ]);
    }
}
