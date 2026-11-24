<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Companies;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Many Companies — `GET /companies`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetManyCompanies extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $idsOrDomains = null,
        private readonly ?string $crmIds = null,
        private readonly ?int $offset = null,
        private readonly ?string $sortBy = null,
        private readonly ?string $sortOrder = null,
        private readonly ?string $search = null,
        private readonly ?string $fields = null,
        private readonly ?int $limit = null,
        private readonly ?string $listId = null,
        private readonly ?string $crmSyncStatus = null,
        private readonly ?string $fieldRejectionReason = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/companies';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'idsOrDomains' => $this->idsOrDomains,
            'crmIds' => $this->crmIds,
            'offset' => $this->offset,
            'sortBy' => $this->sortBy,
            'sortOrder' => $this->sortOrder,
            'search' => $this->search,
            'fields' => $this->fields,
            'limit' => $this->limit,
            'listId' => $this->listId,
            'crmSyncStatus' => $this->crmSyncStatus,
            'fieldRejectionReason' => $this->fieldRejectionReason,
        ]);
    }
}
