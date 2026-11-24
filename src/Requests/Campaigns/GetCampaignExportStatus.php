<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Campaigns;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Campaign Export Status — `GET /campaigns/{campaignId}/export/{exportId}/status`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetCampaignExportStatus extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $campaignId,
        private readonly string $exportId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/export/'.rawurlencode($this->exportId).'/status';
    }
}
