<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\UserGroups;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update User Group — `PATCH /v2/user-groups/{userGroupId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateUserGroup extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param list<string>|null $userIds
     */
    public function __construct(
        private readonly string $userGroupId,
        private readonly ?string $name = null,
        private readonly ?array $userIds = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/user-groups/'.rawurlencode($this->userGroupId);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'userIds' => $this->userIds,
        ]);
    }
}
