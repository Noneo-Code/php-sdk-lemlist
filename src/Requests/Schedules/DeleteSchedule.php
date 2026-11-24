<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Schedules;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete Schedule — `DELETE /schedules/{scheduleId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DeleteSchedule extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(private readonly string $scheduleId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/schedules/'.rawurlencode($this->scheduleId);
    }
}
