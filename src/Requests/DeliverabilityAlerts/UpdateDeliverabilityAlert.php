<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\DeliverabilityAlerts;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update Deliverability Alert — `PATCH /deliverability/alerts/{alertId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateDeliverabilityAlert extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param array<string, mixed>|null $channelConfig
     * @param list<string>|null         $scopeEntities
     */
    public function __construct(
        private readonly string $alertId,
        private readonly ?float $threshold = null,
        private readonly ?string $comparisonOperator = null,
        private readonly ?int $periodDays = null,
        private readonly ?string $periodMode = null,
        private readonly ?array $channelConfig = null,
        private readonly ?array $scopeEntities = null,
        private readonly ?bool $enabled = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/deliverability/alerts/'.rawurlencode($this->alertId);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'threshold' => $this->threshold,
            'comparisonOperator' => $this->comparisonOperator,
            'periodDays' => $this->periodDays,
            'periodMode' => $this->periodMode,
            'channelConfig' => $this->channelConfig,
            'scopeEntities' => $this->scopeEntities,
            'enabled' => $this->enabled,
        ]);
    }
}
