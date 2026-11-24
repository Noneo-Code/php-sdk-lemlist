<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Contacts;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Many Contacts — `GET /contacts`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetManyContacts extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $idsOrEmails = null,
        private readonly ?string $crmIds = null,
        private readonly ?string $search = null,
        private readonly ?string $email = null,
        private readonly ?string $listId = null,
        private readonly ?bool $notInAnyCampaign = null,
        private readonly ?string $companyId = null,
        private readonly ?string $companyDomain = null,
        private readonly ?string $companyLinkedinUrl = null,
        private readonly ?string $companySalesnavUrl = null,
        private readonly ?bool $withPrimaryCompany = null,
        private readonly ?string $fieldRejectionReason = null,
        private readonly ?string $crmSyncStatus = null,
        private readonly ?int $limit = null,
        private readonly ?int $offset = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/contacts';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'idsOrEmails' => $this->idsOrEmails,
            'crmIds' => $this->crmIds,
            'search' => $this->search,
            'email' => $this->email,
            'listId' => $this->listId,
            'notInAnyCampaign' => $this->notInAnyCampaign,
            'companyId' => $this->companyId,
            'companyDomain' => $this->companyDomain,
            'companyLinkedinUrl' => $this->companyLinkedinUrl,
            'companySalesnavUrl' => $this->companySalesnavUrl,
            'withPrimaryCompany' => $this->withPrimaryCompany,
            'fieldRejectionReason' => $this->fieldRejectionReason,
            'crmSyncStatus' => $this->crmSyncStatus,
            'limit' => $this->limit,
            'offset' => $this->offset,
        ]);
    }
}
