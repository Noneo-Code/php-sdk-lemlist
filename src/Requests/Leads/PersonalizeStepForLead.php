<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Leads;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Personalize Step for Lead — `PUT /campaigns/{campaignId}/leads/{leadIdOrEmail}/steps/{stepId}/personalization`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class PersonalizeStepForLead extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    /**
     * @param list<string>|null $cc
     */
    public function __construct(
        private readonly string $campaignId,
        private readonly string $leadIdOrEmail,
        private readonly string $stepId,
        private readonly ?string $variant = null,
        private readonly ?string $subject = null,
        private readonly ?string $message = null,
        private readonly ?array $cc = null,
        private readonly ?bool $plainText = null,
        private readonly ?string $altMessage = null,
        private readonly ?string $altMessagePremium = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/leads/'.rawurlencode($this->leadIdOrEmail).'/steps/'.rawurlencode($this->stepId).'/personalization';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'variant' => $this->variant,
            'subject' => $this->subject,
            'message' => $this->message,
            'cc' => $this->cc,
            'plainText' => $this->plainText,
            'altMessage' => $this->altMessage,
            'altMessagePremium' => $this->altMessagePremium,
        ]);
    }
}
