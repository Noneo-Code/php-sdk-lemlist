<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Campaigns;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Get Batch Campaign Stats — `POST /v2/campaigns/stats/batch`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetBatchCampaignStats extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string>      $campaignIds
     * @param list<string>|null $channels
     */
    public function __construct(
        private readonly array $campaignIds,
        private readonly string $startDate,
        private readonly string $endDate,
        private readonly ?string $sendUser = null,
        private readonly ?string $ABSelected = null,
        private readonly ?array $channels = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/campaigns/stats/batch';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'campaignIds' => $this->campaignIds,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'sendUser' => $this->sendUser,
            'ABSelected' => $this->ABSelected,
            'channels' => $this->channels,
        ]);
    }
}
