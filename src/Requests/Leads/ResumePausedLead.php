<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Leads;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Resume Paused Lead — `POST /leads/start/{leadId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ResumePausedLead extends Request
{
    protected Method $method = Method::POST;

    public function __construct(private readonly string $leadId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/leads/start/'.rawurlencode($this->leadId);
    }
}
