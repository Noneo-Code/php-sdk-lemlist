<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Campaigns;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Add ABM Campaign Leads — `POST /campaigns/{campaignId}/abm-leads`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class AddAbmCampaignLeads extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string> $leadIds
     */
    public function __construct(
        private readonly string $campaignId,
        private readonly array $leadIds,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/abm-leads';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'leadIds' => $this->leadIds,
        ]);
    }
}
