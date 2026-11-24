<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Unsubscribes;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Bulk Unsubscribe Variables — `POST /v2/unsubscribes/variables`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class BulkUnsubscribeVariables extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string> $values
     */
    public function __construct(private readonly array $values)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/unsubscribes/variables';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'values' => $this->values,
        ]);
    }
}
