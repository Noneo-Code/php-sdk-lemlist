<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Warmup;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get warmup settings — `GET /warmup/{userMailboxId}/settings`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetWarmupSettings extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $userMailboxId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/warmup/'.rawurlencode($this->userMailboxId).'/settings';
    }
}
