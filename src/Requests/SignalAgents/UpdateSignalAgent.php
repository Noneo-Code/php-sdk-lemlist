<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\SignalAgents;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update Signal Agent — `PATCH /watchlist`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateSignalAgent extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param list<array<string, mixed>>|null $filters
     */
    public function __construct(
        private readonly string $watchListId,
        private readonly ?string $name = null,
        private readonly ?array $filters = null,
        private readonly ?string $emoji = null,
        private readonly ?string $signalProcessingType = null,
        private readonly ?string $personaId = null,
        private readonly ?bool $activate = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/watchlist';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'watchListId' => $this->watchListId,
            'name' => $this->name,
            'filters' => $this->filters,
            'emoji' => $this->emoji,
            'signalProcessingType' => $this->signalProcessingType,
            'personaId' => $this->personaId,
            'activate' => $this->activate,
        ]);
    }
}
