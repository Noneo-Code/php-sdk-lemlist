<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Warmup;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Start warmup — `POST /warmup/{userMailboxId}/start`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class StartWarmup extends Request
{
    protected Method $method = Method::POST;

    public function __construct(private readonly string $userMailboxId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/warmup/'.rawurlencode($this->userMailboxId).'/start';
    }
}
