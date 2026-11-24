<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Campaigns;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Campaign Reports — `GET /campaigns/reports`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetCampaignReports extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $campaignIds)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/reports';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'campaignIds' => $this->campaignIds,
        ]);
    }
}
