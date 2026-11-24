<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Leads;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Mark Lead as Not Interested in Campaign — `POST /campaigns/{campaignId}/leads/{leadIdOrEmail}/notinterested`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class MarkLeadAsNotInterestedInCampaign extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $campaignId,
        private readonly string $leadIdOrEmail,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/leads/'.rawurlencode($this->leadIdOrEmail).'/notinterested';
    }
}
