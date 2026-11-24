<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Unsubscribes;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List Unsubscribed Variables — `GET /v2/unsubscribes/variables`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListUnsubscribedVariables extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?int $offset = null,
        private readonly ?int $limit = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/unsubscribes/variables';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'offset' => $this->offset,
            'limit' => $this->limit,
        ]);
    }
}
