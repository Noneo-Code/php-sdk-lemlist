<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Leads;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Data\MultipartValue;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasMultipartBody;

/**
 * Upload Audio for Voice Message Step — `POST /leads/audio`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UploadAudioForVoiceMessageStep extends Request implements HasBody
{
    use HasMultipartBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $file,
        private readonly string $leadId,
        private readonly string $stepId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/leads/audio';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'leadId' => $this->leadId,
            'stepId' => $this->stepId,
        ]);
    }

    /**
     * @return list<MultipartValue>
     */
    protected function defaultBody(): array
    {
        return [
            new MultipartValue('file', Payload::file($this->file), basename($this->file)),
        ];
    }
}
