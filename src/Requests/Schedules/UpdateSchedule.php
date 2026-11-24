<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Schedules;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update Schedule — `PATCH /schedules/{scheduleId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateSchedule extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param list<int>|null $weekdays
     */
    public function __construct(
        private readonly string $scheduleId,
        private readonly ?string $name = null,
        private readonly ?int $secondsToWait = null,
        private readonly ?string $timezone = null,
        private readonly ?string $start = null,
        private readonly ?string $end = null,
        private readonly ?array $weekdays = null,
        private readonly ?bool $public = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/schedules/'.rawurlencode($this->scheduleId);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'secondsToWait' => $this->secondsToWait,
            'timezone' => $this->timezone,
            'start' => $this->start,
            'end' => $this->end,
            'weekdays' => $this->weekdays,
            'public' => $this->public,
        ]);
    }
}
