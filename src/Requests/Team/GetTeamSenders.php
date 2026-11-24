<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Team;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Team Senders — `GET /team/senders`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetTeamSenders extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly ?string $state = null)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/team/senders';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'state' => $this->state,
        ]);
    }
}
