<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Inbox;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Send Email — `POST /inbox/email`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class SendEmail extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string>|null $cc
     */
    public function __construct(
        private readonly string $sendUserId,
        private readonly string $sendUserEmail,
        private readonly string $sendUserMailboxId,
        private readonly string $message,
        private readonly ?string $contactId = null,
        private readonly ?string $leadId = null,
        private readonly ?string $subject = null,
        private readonly ?array $cc = null,
        private readonly ?string $replyToActivityId = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/inbox/email';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'sendUserId' => $this->sendUserId,
            'sendUserEmail' => $this->sendUserEmail,
            'sendUserMailboxId' => $this->sendUserMailboxId,
            'message' => $this->message,
            'contactId' => $this->contactId,
            'leadId' => $this->leadId,
            'subject' => $this->subject,
            'cc' => $this->cc,
            'replyToActivityId' => $this->replyToActivityId,
        ]);
    }
}
