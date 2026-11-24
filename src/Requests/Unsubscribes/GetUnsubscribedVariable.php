<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Unsubscribes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Unsubscribed Variable — `GET /v2/unsubscribes/variables/{value}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetUnsubscribedVariable extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $value)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/unsubscribes/variables/'.rawurlencode($this->value);
    }
}
