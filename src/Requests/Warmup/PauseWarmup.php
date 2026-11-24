<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Warmup;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Pause warmup — `POST /warmup/{userMailboxId}/pause`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class PauseWarmup extends Request
{
    protected Method $method = Method::POST;

    public function __construct(private readonly string $userMailboxId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/warmup/'.rawurlencode($this->userMailboxId).'/pause';
    }
}
