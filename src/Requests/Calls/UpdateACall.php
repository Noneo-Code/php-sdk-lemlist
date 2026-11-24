<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Calls;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update a Call — `PATCH /calls/{id}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateACall extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        private readonly string $id,
        private readonly ?string $callStatus = null,
        private readonly ?string $note = null,
        private readonly ?int $duration = null,
        private readonly ?string $recordingUrl = null,
        private readonly ?string $transcript = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/calls/'.rawurlencode($this->id);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'callStatus' => $this->callStatus,
            'note' => $this->note,
            'duration' => $this->duration,
            'recordingUrl' => $this->recordingUrl,
            'transcript' => $this->transcript,
        ]);
    }
}
