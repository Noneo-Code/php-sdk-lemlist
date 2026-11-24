<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Calls;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get a Call — `GET /calls/{id}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetACall extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $id)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/calls/'.rawurlencode($this->id);
    }
}
