<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Leads;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Pause Lead — `POST /leads/pause/{leadId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class PauseLead extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $leadId,
        private readonly ?string $campaignId = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/leads/pause/'.rawurlencode($this->leadId);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'campaignId' => $this->campaignId,
        ]);
    }
}
