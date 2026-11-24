<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\EnrichmentProviders;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List Enrichment Providers — `GET /v2/enrichments/providers`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListEnrichmentProviders extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $type)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/enrichments/providers';
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
