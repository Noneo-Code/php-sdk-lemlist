<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Unsubscribes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Unsubscribe Contact — `POST /v2/unsubscribes/contacts/{contactId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UnsubscribeContact extends Request
{
    protected Method $method = Method::POST;

    public function __construct(private readonly string $contactId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/unsubscribes/contacts/'.rawurlencode($this->contactId);
    }
}
