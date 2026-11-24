<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\UserGroups;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete User Group — `DELETE /v2/user-groups/{userGroupId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DeleteUserGroup extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(private readonly string $userGroupId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/user-groups/'.rawurlencode($this->userGroupId);
    }
}
