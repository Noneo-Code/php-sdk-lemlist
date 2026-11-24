<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Schedules;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Schedule — `GET /schedules/{scheduleId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetSchedule extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $scheduleId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/schedules/'.rawurlencode($this->scheduleId);
    }
}
