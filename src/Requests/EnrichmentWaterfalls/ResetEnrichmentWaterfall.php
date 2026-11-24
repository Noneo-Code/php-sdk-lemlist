<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\EnrichmentWaterfalls;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Reset Enrichment Waterfall — `PUT /v2/enrichments/waterfalls/{waterfallId}/reset`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ResetEnrichmentWaterfall extends Request
{
    protected Method $method = Method::PUT;

    public function __construct(private readonly string $waterfallId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/enrichments/waterfalls/'.rawurlencode($this->waterfallId).'/reset';
    }
}
