<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Enrich;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Bulk Enrich Data — `POST /v2/enrichments/bulk`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class BulkEnrichData extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<array<string, mixed>> $items
     */
    public function __construct(
        private readonly array $items,
        private readonly ?string $webhookUrl = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/enrichments/bulk';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'webhookUrl' => $this->webhookUrl,
        ]);
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function defaultBody(): array
    {
        return $this->items;
    }
}
