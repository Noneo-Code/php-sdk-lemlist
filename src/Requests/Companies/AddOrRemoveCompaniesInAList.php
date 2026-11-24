<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Companies;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Add or Remove Companies in a List — `POST /companies/lists/{listId}/entities`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class AddOrRemoveCompaniesInAList extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string> $companyIds
     */
    public function __construct(
        private readonly string $listId,
        private readonly array $companyIds,
        private readonly ?string $action = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/companies/lists/'.rawurlencode($this->listId).'/entities';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'action' => $this->action,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'companyIds' => $this->companyIds,
        ]);
    }
}
