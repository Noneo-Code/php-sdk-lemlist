<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Leads;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Lead by Email or ID — `GET /leads`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetLeadByEmailOrId extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $id = null,
        private readonly ?string $email = null,
        private readonly ?string $version = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/leads';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'id' => $this->id,
            'email' => $this->email,
            'version' => $this->version,
        ]);
    }
}
