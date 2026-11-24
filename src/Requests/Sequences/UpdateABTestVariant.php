<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Sequences;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update A/B Test Variant — `PATCH /sequences/{sequenceId}/steps/{stepId}/ab-test`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateABTestVariant extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param list<string>|null $cc
     */
    public function __construct(
        private readonly string $sequenceId,
        private readonly string $stepId,
        private readonly ?string $subject = null,
        private readonly ?string $message = null,
        private readonly ?string $altMessage = null,
        private readonly ?string $altMessagePremium = null,
        private readonly ?array $cc = null,
        private readonly ?bool $plainText = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/sequences/'.rawurlencode($this->sequenceId).'/steps/'.rawurlencode($this->stepId).'/ab-test';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'subject' => $this->subject,
            'message' => $this->message,
            'altMessage' => $this->altMessage,
            'altMessagePremium' => $this->altMessagePremium,
            'cc' => $this->cc,
            'plainText' => $this->plainText,
        ]);
    }
}
