<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Inbox;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Send SMS Message — `POST /inbox/sms`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class SendSmsMessage extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $sendUserId,
        private readonly string $from,
        private readonly string $message,
        private readonly ?string $contactId = null,
        private readonly ?string $leadId = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/inbox/sms';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'sendUserId' => $this->sendUserId,
            'from' => $this->from,
            'message' => $this->message,
            'contactId' => $this->contactId,
            'leadId' => $this->leadId,
        ]);
    }
}
