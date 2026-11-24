<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Inbox;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Send WhatsApp Message — `POST /inbox/whatsapp`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class SendWhatsAppMessage extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $sendUserId,
        private readonly string $sendUserWhatsappAccountId,
        private readonly string $contactId,
        private readonly string $leadId,
        private readonly string $message,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/inbox/whatsapp';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'sendUserId' => $this->sendUserId,
            'sendUserWhatsappAccountId' => $this->sendUserWhatsappAccountId,
            'contactId' => $this->contactId,
            'leadId' => $this->leadId,
            'message' => $this->message,
        ]);
    }
}
