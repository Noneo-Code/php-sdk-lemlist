<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\ContactSourcing;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Add a Sourced Contact — `POST /contact-sourcing/contacts`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class AddASourcedContact extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $leadId,
        private readonly string $companyId,
        private readonly ?string $listId = null,
        private readonly ?bool $findEmail = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/contact-sourcing/contacts';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'leadId' => $this->leadId,
            'companyId' => $this->companyId,
            'listId' => $this->listId,
            'findEmail' => $this->findEmail,
        ]);
    }
}
