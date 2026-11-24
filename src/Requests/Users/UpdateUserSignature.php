<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Users;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update User Signature — `PATCH /users/{userId}/signature`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateUserSignature extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        private readonly string $userId,
        private readonly ?string $signature = null,
        private readonly ?string $plainTextSignature = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/users/'.rawurlencode($this->userId).'/signature';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'signature' => $this->signature,
            'plainTextSignature' => $this->plainTextSignature,
        ]);
    }
}
