<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\SignalAgents;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Remove Signal Agent Trigger — `DELETE /campaigns/{campaignId}/triggers/watch-lists/{watchListId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class RemoveSignalAgentTrigger extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $campaignId,
        private readonly string $watchListId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/triggers/watch-lists/'.rawurlencode($this->watchListId);
    }
}
