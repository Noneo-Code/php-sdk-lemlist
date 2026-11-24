<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Campaigns;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Skip Step for Everyone — `POST /campaigns/{campaignId}/steps/{stepId}/skip`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class SkipStepForEveryone extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $campaignId,
        private readonly string $stepId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/steps/'.rawurlencode($this->stepId).'/skip';
    }
}
