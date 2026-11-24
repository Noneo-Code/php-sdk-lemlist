<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Leads;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Campaign Leads — `GET /campaigns/{campaignId}/leads/`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetCampaignLeads extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $campaignId,
        private readonly ?string $state = null,
        private readonly ?int $limit = null,
        private readonly ?int $offset = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/leads/';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'state' => $this->state,
            'limit' => $this->limit,
            'offset' => $this->offset,
        ]);
    }
}
