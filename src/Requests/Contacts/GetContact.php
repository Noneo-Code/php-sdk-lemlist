<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Contact — `GET /contacts/{idOrEmail}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetContact extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $idOrEmail)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/contacts/'.rawurlencode($this->idOrEmail);
    }
}
