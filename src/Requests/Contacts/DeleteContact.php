<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete Contact — `DELETE /contacts/{idOrEmail}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DeleteContact extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(private readonly string $idOrEmail)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/contacts/'.rawurlencode($this->idOrEmail);
    }
}
