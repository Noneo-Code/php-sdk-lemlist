<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Leads;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Reset Step Personalization for Lead — `DELETE /campaigns/{campaignId}/leads/{leadIdOrEmail}/steps/{stepId}/personalization`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ResetStepPersonalizationForLead extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $campaignId,
        private readonly string $leadIdOrEmail,
        private readonly string $stepId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/leads/'.rawurlencode($this->leadIdOrEmail).'/steps/'.rawurlencode($this->stepId).'/personalization';
    }
}
