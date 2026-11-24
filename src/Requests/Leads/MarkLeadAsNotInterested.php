<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Leads;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Mark Lead as Not Interested — `POST /leads/notinterested/{leadIdOrEmail}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class MarkLeadAsNotInterested extends Request
{
    protected Method $method = Method::POST;

    public function __construct(private readonly string $leadIdOrEmail)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/leads/notinterested/'.rawurlencode($this->leadIdOrEmail);
    }
}
