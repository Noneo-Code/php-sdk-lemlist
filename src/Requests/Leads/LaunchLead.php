<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Leads;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Launch Lead — `POST /leads/review/{leadId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class LaunchLead extends Request
{
    protected Method $method = Method::POST;

    public function __construct(private readonly string $leadId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/leads/review/'.rawurlencode($this->leadId);
    }
}
