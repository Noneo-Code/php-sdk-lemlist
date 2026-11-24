<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Unsubscribes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Contact Subscription Status — `GET /v2/unsubscribes/contacts/{contactId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetContactSubscriptionStatus extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $contactId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/unsubscribes/contacts/'.rawurlencode($this->contactId);
    }
}
