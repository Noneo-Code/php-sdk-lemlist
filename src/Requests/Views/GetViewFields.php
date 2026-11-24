<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Views;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get View Fields — `GET /views/fields`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetViewFields extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $entity)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/views/fields';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'entity' => $this->entity,
        ]);
    }
}
