<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Unsubscribes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Re-subscribe Contact — `DELETE /v2/unsubscribes/contacts/{contactId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ReSubscribeContact extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(private readonly string $contactId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/unsubscribes/contacts/'.rawurlencode($this->contactId);
    }
}
