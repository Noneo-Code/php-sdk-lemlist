<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Leads;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Lead by Email — `GET /leads/{email}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetLeadByEmail extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $email,
        private readonly ?string $version = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/leads/'.rawurlencode($this->email);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'version' => $this->version,
        ]);
    }
}
