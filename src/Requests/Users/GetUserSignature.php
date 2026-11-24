<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get User Signature — `GET /users/{userId}/signature`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetUserSignature extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $userId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/users/'.rawurlencode($this->userId).'/signature';
    }
}
