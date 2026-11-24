<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Domains;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Purchase Domain — `POST /domains-core/purchase`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class PurchaseDomain extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<array<string, mixed>>|null $dnsRecords
     * @param array<string, mixed>|null       $billingContact
     */
    public function __construct(
        private readonly string $domain,
        private readonly ?string $provider = null,
        private readonly ?bool $isTransfer = null,
        private readonly ?string $authCode = null,
        private readonly ?array $dnsRecords = null,
        private readonly ?array $billingContact = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/domains-core/purchase';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'domain' => $this->domain,
            'provider' => $this->provider,
            'isTransfer' => $this->isTransfer,
            'authCode' => $this->authCode,
            'dnsRecords' => $this->dnsRecords,
            'billingContact' => $this->billingContact,
        ]);
    }
}
