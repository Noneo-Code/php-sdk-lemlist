<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Inbox;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Send LinkedIn Message — `POST /inbox/linkedin`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class SendLinkedInMessage extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $sendUserId,
        private readonly string $leadId,
        private readonly string $contactId,
        private readonly string $message,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/inbox/linkedin';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'sendUserId' => $this->sendUserId,
            'leadId' => $this->leadId,
            'contactId' => $this->contactId,
            'message' => $this->message,
        ]);
    }
}
