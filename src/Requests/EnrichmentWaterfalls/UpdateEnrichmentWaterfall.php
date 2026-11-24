<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\EnrichmentWaterfalls;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update Enrichment Waterfall — `PATCH /v2/enrichments/waterfalls/{waterfallId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateEnrichmentWaterfall extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param list<array<string, mixed>>|null $providers
     */
    public function __construct(
        private readonly string $waterfallId,
        private readonly ?string $name = null,
        private readonly ?array $providers = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/enrichments/waterfalls/'.rawurlencode($this->waterfallId);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'providers' => $this->providers,
        ]);
    }
}
