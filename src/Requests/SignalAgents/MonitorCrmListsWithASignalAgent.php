<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\SignalAgents;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Monitor CRM Lists with a Signal Agent — `POST /watchlist/crm-lists`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class MonitorCrmListsWithASignalAgent extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string> $crmListIds
     */
    public function __construct(
        private readonly string $watchListId,
        private readonly array $crmListIds,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/watchlist/crm-lists';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'watchListId' => $this->watchListId,
            'crmListIds' => $this->crmListIds,
        ]);
    }
}
