<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Schedules;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create Schedule — `POST /schedules`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class CreateSchedule extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<int> $weekdays
     */
    public function __construct(
        private readonly string $name,
        private readonly string $timezone,
        private readonly string $start,
        private readonly string $end,
        private readonly array $weekdays,
        private readonly ?int $secondsToWait = null,
        private readonly ?bool $public = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/schedules';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'timezone' => $this->timezone,
            'start' => $this->start,
            'end' => $this->end,
            'weekdays' => $this->weekdays,
            'secondsToWait' => $this->secondsToWait,
            'public' => $this->public,
        ]);
    }
}
