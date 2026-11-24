<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Companies;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Company — `GET /companies/{companyId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetCompany extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $companyId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/companies/'.rawurlencode($this->companyId);
    }
}
