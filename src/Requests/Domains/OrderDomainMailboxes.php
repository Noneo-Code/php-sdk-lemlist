<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Domains;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Order Mailboxes — `POST /domains-core/{domainId}/mailboxes`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class OrderDomainMailboxes extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<array<string, mixed>> $emails
     */
    public function __construct(
        private readonly string $domainId,
        private readonly array $emails,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/domains-core/'.rawurlencode($this->domainId).'/mailboxes';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'emails' => $this->emails,
        ]);
    }
}
