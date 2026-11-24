<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\EnrichmentWaterfalls;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List Enrichment Waterfalls — `GET /v2/enrichments/waterfalls`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListEnrichmentWaterfalls extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly ?string $type = null)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/enrichments/waterfalls';
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
