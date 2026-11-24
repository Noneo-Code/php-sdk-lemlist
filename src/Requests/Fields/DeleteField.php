<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Fields;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete Field — `DELETE /fields/{entity}/{name}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DeleteField extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $entity,
        private readonly string $name,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/fields/'.rawurlencode($this->entity).'/'.rawurlencode($this->name);
    }
}
