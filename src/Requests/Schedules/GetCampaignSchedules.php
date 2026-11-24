<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Schedules;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Campaign Schedules — `GET /campaigns/{campaignId}/schedules/`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetCampaignSchedules extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $campaignId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/schedules/';
    }
}
