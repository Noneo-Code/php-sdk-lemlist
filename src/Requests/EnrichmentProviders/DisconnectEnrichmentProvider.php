<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\EnrichmentProviders;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Disconnect Provider — `DELETE /v2/enrichments/providers/{providerId}/connection`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DisconnectEnrichmentProvider extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(private readonly string $providerId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/enrichments/providers/'.rawurlencode($this->providerId).'/connection';
    }
}
