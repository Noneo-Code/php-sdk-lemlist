<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\DeliverabilityAlerts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete Deliverability Alert — `DELETE /deliverability/alerts/{alertId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DeleteDeliverabilityAlert extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(private readonly string $alertId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/deliverability/alerts/'.rawurlencode($this->alertId);
    }
}
