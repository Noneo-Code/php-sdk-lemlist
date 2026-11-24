<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Fields;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List Fields — `GET /fields`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListFields extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $entity = null,
        private readonly ?string $source = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/fields';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'entity' => $this->entity,
            'source' => $this->source,
        ]);
    }
}
