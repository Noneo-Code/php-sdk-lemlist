<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Companies;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Search & Connect Companies in the CRM — `POST /companies/crm/search-and-connect`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class SearchConnectCompaniesInTheCrm extends Request implements HasBody
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
        return '/companies/crm/search-and-connect';
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
