<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\PeopleDatabase;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Search LinkedIn Post Engagers — `POST /database/people/linkedin-post-engagement`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class SearchLinkedInPostEngagers extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<array<string, mixed>>|null $filters
     */
    public function __construct(
        private readonly string $url,
        private readonly ?string $type = null,
        private readonly ?array $filters = null,
        private readonly ?int $size = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/database/people/linkedin-post-engagement';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'url' => $this->url,
            'type' => $this->type,
            'filters' => $this->filters,
            'size' => $this->size,
        ]);
    }
}
