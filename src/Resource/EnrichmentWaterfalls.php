<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\EnrichmentWaterfallListResponseDto;
use Noneo\Sdk\Lemlist\Dto\EnrichmentWaterfallResponseDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\EnrichmentWaterfalls\GetEnrichmentWaterfall;
use Noneo\Sdk\Lemlist\Requests\EnrichmentWaterfalls\ListEnrichmentWaterfalls;
use Noneo\Sdk\Lemlist\Requests\EnrichmentWaterfalls\ResetEnrichmentWaterfall;
use Noneo\Sdk\Lemlist\Requests\EnrichmentWaterfalls\UpdateEnrichmentWaterfall;

/**
 * Section « EnrichmentWaterfalls » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class EnrichmentWaterfalls
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * List Enrichment Waterfalls.
     *
     * `GET /v2/enrichments/waterfalls`
     *
     * @param string|null $type Restrict the list to one enrichment type (valeurs : email, phone)
     */
    public function listEnrichmentWaterfalls(?string $type = null): EnrichmentWaterfallListResponseDto
    {
        $response = $this->connector->send(new ListEnrichmentWaterfalls(type: $type));

        return EnrichmentWaterfallListResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Get Enrichment Waterfall.
     *
     * `GET /v2/enrichments/waterfalls/{waterfallId}`
     *
     * @param string $waterfallId Id of the waterfall, as returned by the list endpoint: `default_email` or `default_phone` for a default waterfall, an `ecw_` id for a custom one
     */
    public function getEnrichmentWaterfall(string $waterfallId): EnrichmentWaterfallResponseDto
    {
        $response = $this->connector->send(new GetEnrichmentWaterfall(waterfallId: $waterfallId));

        return EnrichmentWaterfallResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Update Enrichment Waterfall.
     *
     * `PATCH /v2/enrichments/waterfalls/{waterfallId}`
     *
     * @param string                          $waterfallId Id of the waterfall, as returned by the list endpoint: `default_email` or `default_phone` for a default waterfall, an `ecw_` id for a custom one
     * @param list<array<string, mixed>>|null $providers   Replaces the whole order, may be partial; left-out providers are appended, disabled
     */
    public function updateEnrichmentWaterfall(
        string $waterfallId,
        ?string $name = null,
        ?array $providers = null,
    ): EnrichmentWaterfallResponseDto {
        $response = $this->connector->send(new UpdateEnrichmentWaterfall(
            waterfallId: $waterfallId,
            name: $name,
            providers: $providers,
        ));

        return EnrichmentWaterfallResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Reset Enrichment Waterfall.
     *
     * `PUT /v2/enrichments/waterfalls/{waterfallId}/reset`
     *
     * @param string $waterfallId `default_email` or `default_phone` (valeurs : default_email, default_phone)
     */
    public function resetEnrichmentWaterfall(string $waterfallId): EnrichmentWaterfallResponseDto
    {
        $response = $this->connector->send(new ResetEnrichmentWaterfall(waterfallId: $waterfallId));

        return EnrichmentWaterfallResponseDto::fromArray(ResponseDecoder::object($response));
    }
}
