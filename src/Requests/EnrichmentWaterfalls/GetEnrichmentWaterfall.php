<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\EnrichmentWaterfalls;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Enrichment Waterfall — `GET /v2/enrichments/waterfalls/{waterfallId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetEnrichmentWaterfall extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $waterfallId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/enrichments/waterfalls/'.rawurlencode($this->waterfallId);
    }
}
