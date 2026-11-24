<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Calls;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Log a Call — `POST /calls`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class LogACall extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $externalId,
        private readonly string $userId,
        private readonly string $direction,
        private readonly \DateTimeInterface|string $startedAt,
        private readonly ?string $from = null,
        private readonly ?string $to = null,
        private readonly ?int $duration = null,
        private readonly ?string $callStatus = null,
        private readonly ?string $note = null,
        private readonly ?string $recordingUrl = null,
        private readonly ?string $transcript = null,
        private readonly ?string $provider = null,
        private readonly ?string $taskId = null,
        private readonly ?string $leadId = null,
        private readonly ?string $contactId = null,
        private readonly ?string $email = null,
        private readonly ?string $phone = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/calls';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'externalId' => $this->externalId,
            'userId' => $this->userId,
            'direction' => $this->direction,
            'startedAt' => $this->startedAt,
            'from' => $this->from,
            'to' => $this->to,
            'duration' => $this->duration,
            'callStatus' => $this->callStatus,
            'note' => $this->note,
            'recordingUrl' => $this->recordingUrl,
            'transcript' => $this->transcript,
            'provider' => $this->provider,
            'taskId' => $this->taskId,
            'leadId' => $this->leadId,
            'contactId' => $this->contactId,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);
    }
}
