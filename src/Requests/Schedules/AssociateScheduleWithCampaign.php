<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Schedules;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Associate Schedule with Campaign — `POST /campaigns/{campaignId}/schedules/{scheduleId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class AssociateScheduleWithCampaign extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $campaignId,
        private readonly string $scheduleId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/schedules/'.rawurlencode($this->scheduleId);
    }
}
