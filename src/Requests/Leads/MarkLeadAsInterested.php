<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Leads;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Mark Lead as Interested — `POST /leads/interested/{leadIdOrEmail}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class MarkLeadAsInterested extends Request
{
    protected Method $method = Method::POST;

    public function __construct(private readonly string $leadIdOrEmail)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/leads/interested/'.rawurlencode($this->leadIdOrEmail);
    }
}
