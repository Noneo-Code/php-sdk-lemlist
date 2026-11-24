<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Senders;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Add Campaign Senders — `POST /campaigns/{campaignId}/senders`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class AddCampaignSenders extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<array<string, mixed>> $senders
     */
    public function __construct(
        private readonly string $campaignId,
        private readonly array $senders,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/senders';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'senders' => $this->senders,
        ]);
    }
}
