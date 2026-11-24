<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\SelfRecovery;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Self-recovery Config — `GET /self-recovery/config`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetSelfRecoveryConfig extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/self-recovery/config';
    }
}
