<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Leads;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Unsubscribe Lead from Campaign — `DELETE /campaigns/{campaignId}/leads/{email}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UnsubscribeLeadFromCampaignByEmail extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $campaignId,
        private readonly string $email,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/leads/'.rawurlencode($this->email);
    }
}
