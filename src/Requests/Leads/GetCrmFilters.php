<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Leads;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get CRM Filters — `GET /crm/filters`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetCrmFilters extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly ?string $type = null)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/crm/filters';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'type' => $this->type,
        ]);
    }
}
