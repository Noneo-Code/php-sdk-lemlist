<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Enrich;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Enrich Lead — `POST /leads/{leadId}/enrich`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class EnrichLead extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $leadId,
        private readonly ?bool $findEmail = null,
        private readonly ?bool $verifyEmail = null,
        private readonly ?bool $linkedinEnrichment = null,
        private readonly ?bool $findPhone = null,
        private readonly ?string $webhookUrl = null,
        private readonly ?bool $force = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/leads/'.rawurlencode($this->leadId).'/enrich';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'findEmail' => $this->findEmail,
            'verifyEmail' => $this->verifyEmail,
            'linkedinEnrichment' => $this->linkedinEnrichment,
            'findPhone' => $this->findPhone,
            'webhookUrl' => $this->webhookUrl,
            'force' => $this->force,
        ]);
    }
}
