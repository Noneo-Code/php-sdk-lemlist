<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Companies;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Engage Company — `POST /companies/{companyId}/engage`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class EngageCompany extends Request
{
    protected Method $method = Method::POST;

    public function __construct(private readonly string $companyId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/companies/'.rawurlencode($this->companyId).'/engage';
    }
}
