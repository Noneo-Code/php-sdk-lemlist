<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Domains;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List Domain Mailboxes — `GET /domains-core/mailboxes`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListDomainMailboxes extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly ?string $domainId = null)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/domains-core/mailboxes';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'domainId' => $this->domainId,
        ]);
    }
}
