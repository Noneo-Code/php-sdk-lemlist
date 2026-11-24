<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Enrich;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Enrichment Result — `GET /enrich/{enrichId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetEnrichmentResult extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $enrichId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/enrich/'.rawurlencode($this->enrichId);
    }
}
