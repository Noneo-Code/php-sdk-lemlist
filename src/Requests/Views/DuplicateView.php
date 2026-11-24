<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Views;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Duplicate View — `POST /views/{viewId}/duplicate`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DuplicateView extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $viewId,
        private readonly string $entity,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/views/'.rawurlencode($this->viewId).'/duplicate';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'entity' => $this->entity,
        ]);
    }
}
