<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Views;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update View — `PATCH /views/{viewId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateView extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param array<string, mixed>|null       $filters
     * @param array<string, mixed>|null       $sort
     * @param list<array<string, mixed>>|null $columns
     */
    public function __construct(
        private readonly string $viewId,
        private readonly string $entity,
        private readonly ?string $name = null,
        private readonly ?string $icon = null,
        private readonly ?string $visibility = null,
        private readonly ?array $filters = null,
        private readonly ?array $sort = null,
        private readonly ?array $columns = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/views/'.rawurlencode($this->viewId);
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
