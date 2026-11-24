<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Schedules;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Many Schedules — `GET /schedules`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetManySchedules extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?int $page = null,
        private readonly ?int $offset = null,
        private readonly ?int $limit = null,
        private readonly ?string $sortBy = null,
        private readonly ?string $sortOrder = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/schedules';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'page' => $this->page,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'sortBy' => $this->sortBy,
            'sortOrder' => $this->sortOrder,
        ]);
    }
}
