<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\UserGroups;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Edit User Group Members — `POST /v2/user-groups/{userGroupId}/members`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class EditUserGroupMembers extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string>|null $addUserIds
     * @param list<string>|null $removeUserIds
     */
    public function __construct(
        private readonly string $userGroupId,
        private readonly ?array $addUserIds = null,
        private readonly ?array $removeUserIds = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/user-groups/'.rawurlencode($this->userGroupId).'/members';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'addUserIds' => $this->addUserIds,
            'removeUserIds' => $this->removeUserIds,
        ]);
    }
}
