<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Views;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create View — `POST /views`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class CreateView extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param array<string, mixed>|null       $filters
     * @param array<string, mixed>|null       $sort
     * @param list<array<string, mixed>>|null $columns
     */
    public function __construct(
        private readonly string $entity,
        private readonly string $name,
        private readonly ?string $icon = null,
        private readonly ?string $visibility = null,
        private readonly ?array $filters = null,
        private readonly ?array $sort = null,
        private readonly ?array $columns = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/views';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'entity' => $this->entity,
            'name' => $this->name,
            'icon' => $this->icon,
            'visibility' => $this->visibility,
            'filters' => $this->filters,
            'sort' => $this->sort,
            'columns' => $this->columns,
        ]);
    }
}
