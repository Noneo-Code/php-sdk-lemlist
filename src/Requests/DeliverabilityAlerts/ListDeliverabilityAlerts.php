<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\DeliverabilityAlerts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List Deliverability Alerts — `GET /deliverability/alerts`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListDeliverabilityAlerts extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/deliverability/alerts';
    }
}
