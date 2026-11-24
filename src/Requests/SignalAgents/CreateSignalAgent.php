<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\SignalAgents;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create Signal Agent — `POST /watchlist`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class CreateSignalAgent extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<array<string, mixed>>|null $filters
     * @param array<string, mixed>|null       $signalOpportunityTemplate
     */
    public function __construct(
        private readonly string $name,
        private readonly string $type,
        private readonly ?array $filters = null,
        private readonly ?string $emoji = null,
        private readonly ?string $segmentType = null,
        private readonly ?string $signalProcessingType = null,
        private readonly ?array $signalOpportunityTemplate = null,
        private readonly ?string $personaId = null,
        private readonly ?string $campaignId = null,
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
            'name' => $this->name,
            'type' => $this->type,
            'filters' => $this->filters,
            'emoji' => $this->emoji,
            'segmentType' => $this->segmentType,
            'signalProcessingType' => $this->signalProcessingType,
            'signalOpportunityTemplate' => $this->signalOpportunityTemplate,
            'personaId' => $this->personaId,
            'campaignId' => $this->campaignId,
            'activate' => $this->activate,
        ]);
    }
}
