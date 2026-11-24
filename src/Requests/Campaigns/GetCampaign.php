<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Campaigns;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Campaign — `GET /campaigns/{campaignId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetCampaign extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $campaignId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId);
    }
}
