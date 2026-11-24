<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\PeopleDatabase;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete Persona — `DELETE /database/personas/{personaId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DeletePersona extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(private readonly string $personaId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/database/personas/'.rawurlencode($this->personaId);
    }
}
