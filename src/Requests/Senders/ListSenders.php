<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Senders;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List Senders — `GET /senders`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListSenders extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly ?string $campaignId = null)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/senders';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'campaignId' => $this->campaignId,
        ]);
    }
}
