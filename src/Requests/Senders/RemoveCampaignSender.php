<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Senders;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Remove Campaign Sender — `DELETE /campaigns/{campaignId}/senders/{userId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class RemoveCampaignSender extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $campaignId,
        private readonly string $userId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/senders/'.rawurlencode($this->userId);
    }
}
