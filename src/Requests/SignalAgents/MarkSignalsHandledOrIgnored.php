<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\SignalAgents;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Mark signals handled or ignored — `PUT /watchlist/signals`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class MarkSignalsHandledOrIgnored extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    /**
     * @param list<string> $signalIds
     */
    public function __construct(
        private readonly array $signalIds,
        private readonly string $status,
        private readonly ?string $reason = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/watchlist/signals';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'signalIds' => $this->signalIds,
            'status' => $this->status,
            'reason' => $this->reason,
        ]);
    }
}
