<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\EnrichmentProviders;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Connect Provider — `PUT /v2/enrichments/providers/{providerId}/connection`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ConnectEnrichmentProvider extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function __construct(
        private readonly string $providerId,
        #[\SensitiveParameter] private readonly string $apiKey,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/enrichments/providers/'.rawurlencode($this->providerId).'/connection';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'apiKey' => $this->apiKey,
        ]);
    }
}
