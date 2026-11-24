<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Leads;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update Lead in a Campaign — `PATCH /campaigns/{campaignId}/leads/{leadId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateLeadInACampaign extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        private readonly string $campaignId,
        private readonly string $leadId,
        private readonly ?string $firstName = null,
        private readonly ?string $lastName = null,
        private readonly ?string $companyName = null,
        private readonly ?string $jobTitle = null,
        private readonly ?string $preferredContactMethod = null,
        private readonly ?string $updateStrategy = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/leads/'.rawurlencode($this->leadId);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'updateStrategy' => $this->updateStrategy,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'companyName' => $this->companyName,
            'jobTitle' => $this->jobTitle,
            'preferredContactMethod' => $this->preferredContactMethod,
        ]);
    }
}
