<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Companies;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create Companies in the CRM — `POST /companies/crm/create`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class CreateCompaniesInTheCrm extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string>|null $idsOrDomains
     */
    public function __construct(
        private readonly ?array $idsOrDomains = null,
        private readonly ?string $listId = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/companies/crm/create';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'idsOrDomains' => $this->idsOrDomains,
            'listId' => $this->listId,
        ]);
    }
}
