<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Companies;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete Company — `DELETE /companies/{companyId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DeleteCompany extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $companyId,
        private readonly ?bool $force = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/companies/'.rawurlencode($this->companyId);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'force' => $this->force,
        ]);
    }
}
