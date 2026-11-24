<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Inbox;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Label — `GET /inbox/labels/{labelId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetLabel extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $labelId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/inbox/labels/'.rawurlencode($this->labelId);
    }
}
