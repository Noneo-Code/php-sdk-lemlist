<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Domains;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update Domain Mailbox — `PATCH /domains-core/mailboxes/{mailboxId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateDomainMailbox extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        private readonly string $mailboxId,
        private readonly string $assignToUserId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/domains-core/mailboxes/'.rawurlencode($this->mailboxId);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'assignToUserId' => $this->assignToUserId,
        ]);
    }
}
