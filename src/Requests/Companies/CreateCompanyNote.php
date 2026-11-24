<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Companies;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create Company Note — `POST /companies/{companyId}/notes`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class CreateCompanyNote extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $companyId,
        private readonly string $note,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/companies/'.rawurlencode($this->companyId).'/notes';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'note' => $this->note,
        ]);
    }
}
