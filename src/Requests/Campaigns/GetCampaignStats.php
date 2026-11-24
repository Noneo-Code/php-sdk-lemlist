<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Campaigns;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Campaign Stats — `GET /v2/campaigns/{campaignId}/stats`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetCampaignStats extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $campaignId,
        private readonly \DateTimeInterface|string $startDate,
        private readonly \DateTimeInterface|string $endDate,
        private readonly ?string $sendUser = null,
        private readonly ?string $ABSelected = null,
        private readonly ?string $channels = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/campaigns/'.rawurlencode($this->campaignId).'/stats';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'sendUser' => $this->sendUser,
            'ABSelected' => $this->ABSelected,
            'channels' => $this->channels,
        ]);
    }
}
