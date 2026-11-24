<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Senders;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Team Sender Exclusions — `GET /team/dynamic-sender-exclusions`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetTeamSenderExclusions extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/team/dynamic-sender-exclusions';
    }
}
