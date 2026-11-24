<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\DeliverabilityAlerts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Deliverability Alert — `GET /deliverability/alerts/{alertId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetDeliverabilityAlert extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $alertId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/deliverability/alerts/'.rawurlencode($this->alertId);
    }
}
