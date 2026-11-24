<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Views;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete View — `DELETE /views/{viewId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DeleteView extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $viewId,
        private readonly string $entity,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/views/'.rawurlencode($this->viewId);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'entity' => $this->entity,
        ]);
    }
}
