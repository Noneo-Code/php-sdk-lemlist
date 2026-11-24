<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Leads;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete or Unsubscribe Lead — `DELETE /campaigns/{campaignId}/leads/{leadId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DeleteOrUnsubscribeLead extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $campaignId,
        private readonly string $leadId,
        private readonly ?string $action = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/leads/'.rawurlencode($this->leadId);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'action' => $this->action,
        ]);
    }
}
