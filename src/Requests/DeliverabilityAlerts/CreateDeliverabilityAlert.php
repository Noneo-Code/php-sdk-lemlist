<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\DeliverabilityAlerts;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create Deliverability Alert — `POST /deliverability/alerts`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class CreateDeliverabilityAlert extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string>|null         $scopeEntities
     * @param array<string, mixed>|null $channelConfig
     */
    public function __construct(
        private readonly string $widget,
        private readonly string $metric,
        private readonly string $severity,
        private readonly string $scope,
        private readonly float $threshold,
        private readonly string $comparisonOperator,
        private readonly int $periodDays,
        private readonly string $periodMode,
        private readonly ?array $scopeEntities = null,
        private readonly ?array $channelConfig = null,
        private readonly ?int $recheckDelayHours = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/deliverability/alerts';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'widget' => $this->widget,
            'metric' => $this->metric,
            'severity' => $this->severity,
            'scope' => $this->scope,
            'threshold' => $this->threshold,
            'comparisonOperator' => $this->comparisonOperator,
            'periodDays' => $this->periodDays,
            'periodMode' => $this->periodMode,
            'scopeEntities' => $this->scopeEntities,
            'channelConfig' => $this->channelConfig,
            'recheckDelayHours' => $this->recheckDelayHours,
        ]);
    }
}
