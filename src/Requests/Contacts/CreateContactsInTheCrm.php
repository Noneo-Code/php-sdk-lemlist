<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Contacts;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create Contacts in the CRM — `POST /contacts/crm/create`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class CreateContactsInTheCrm extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string>|null $idsOrEmails
     */
    public function __construct(
        private readonly ?array $idsOrEmails = null,
        private readonly ?string $listId = null,
        private readonly ?bool $asLead = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/contacts/crm/create';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'idsOrEmails' => $this->idsOrEmails,
            'listId' => $this->listId,
            'asLead' => $this->asLead,
        ]);
    }
}
