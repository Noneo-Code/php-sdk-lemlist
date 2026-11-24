<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\UserGroups;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create User Group — `POST /v2/user-groups`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class CreateUserGroup extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string> $userIds
     */
    public function __construct(
        private readonly string $name,
        private readonly array $userIds,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/user-groups';
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
