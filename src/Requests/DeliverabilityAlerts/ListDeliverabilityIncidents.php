<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\DeliverabilityAlerts;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List Deliverability Incidents — `GET /deliverability/incidents`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListDeliverabilityIncidents extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $type = null,
        private readonly ?string $state = null,
        private readonly ?string $userId = null,
        private readonly ?string $since = null,
        private readonly ?string $until = null,
        private readonly ?int $limit = null,
        private readonly ?int $skip = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/deliverability/incidents';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'type' => $this->type,
            'state' => $this->state,
            'userId' => $this->userId,
            'since' => $this->since,
            'until' => $this->until,
            'limit' => $this->limit,
            'skip' => $this->skip,
        ]);
    }
}
