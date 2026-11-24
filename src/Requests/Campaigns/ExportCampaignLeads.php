<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Campaigns;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Export Campaign Leads — `GET /v2/campaigns/{campaignId}/export/leads`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ExportCampaignLeads extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $campaignId,
        private readonly ?string $state = null,
        private readonly ?string $format = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/campaigns/'.rawurlencode($this->campaignId).'/export/leads';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'state' => $this->state,
            'format' => $this->format,
        ]);
    }
}
