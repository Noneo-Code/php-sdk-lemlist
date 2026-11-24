<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Unsubscribes;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Export Unsubscribed Variables — `GET /v2/unsubscribes/exports/variables`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ExportUnsubscribedVariables extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly ?string $format = null)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/unsubscribes/exports/variables';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'format' => $this->format,
        ]);
    }
}
