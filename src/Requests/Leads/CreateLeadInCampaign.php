<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Leads;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create Lead in Campaign — `POST /campaigns/{campaignId}/leads/`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class CreateLeadInCampaign extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param array<string, mixed> $additional
     */
    public function __construct(
        private readonly string $campaignId,
        private readonly ?string $email = null,
        private readonly ?string $firstName = null,
        private readonly ?string $lastName = null,
        private readonly ?string $companyName = null,
        private readonly ?string $jobTitle = null,
        private readonly ?string $linkedinUrl = null,
        private readonly ?string $picture = null,
        private readonly ?string $phone = null,
        private readonly ?string $companyDomain = null,
        private readonly ?string $icebreaker = null,
        private readonly ?string $timezone = null,
        private readonly ?string $contactOwner = null,
        private readonly ?string $crmId = null,
        private readonly ?bool $deduplicate = null,
        private readonly ?bool $linkedinEnrichment = null,
        private readonly ?bool $findEmail = null,
        private readonly ?bool $verifyEmail = null,
        private readonly ?bool $findPhone = null,
        private readonly ?string $updateStrategy = null,
        private readonly array $additional = [],
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/leads/';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'deduplicate' => $this->deduplicate,
            'linkedinEnrichment' => $this->linkedinEnrichment,
            'findEmail' => $this->findEmail,
            'verifyEmail' => $this->verifyEmail,
            'findPhone' => $this->findPhone,
            'updateStrategy' => $this->updateStrategy,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'email' => $this->email,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'companyName' => $this->companyName,
            'jobTitle' => $this->jobTitle,
            'linkedinUrl' => $this->linkedinUrl,
            'picture' => $this->picture,
            'phone' => $this->phone,
            'companyDomain' => $this->companyDomain,
            'icebreaker' => $this->icebreaker,
            'timezone' => $this->timezone,
            'contactOwner' => $this->contactOwner,
            'crmId' => $this->crmId,
        ], $this->additional);
    }
}
