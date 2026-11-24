<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Webhooks;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Add Webhook — `POST /hooks`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class AddWebhook extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $targetUrl,
        private readonly ?string $type = null,
        #[\SensitiveParameter] private readonly ?string $secret = null,
        private readonly ?string $campaignId = null,
        private readonly ?bool $isFirst = null,
        private readonly ?string $zapId = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/hooks';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'campaignId' => $this->campaignId,
            'isFirst' => $this->isFirst,
            'zapId' => $this->zapId,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'targetUrl' => $this->targetUrl,
            'type' => $this->type,
            'secret' => $this->secret,
        ]);
    }
}
