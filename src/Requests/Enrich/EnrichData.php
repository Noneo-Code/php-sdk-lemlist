<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Enrich;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Enrich Data — `POST /enrich`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class EnrichData extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        private readonly ?bool $findEmail = null,
        private readonly ?bool $verifyEmail = null,
        private readonly ?bool $linkedinEnrichment = null,
        private readonly ?string $email = null,
        private readonly ?string $linkedinUrl = null,
        private readonly ?string $firstName = null,
        private readonly ?string $lastName = null,
        private readonly ?string $companyDomain = null,
        private readonly ?string $companyName = null,
        private readonly ?string $jobTitle = null,
        private readonly ?bool $findPhone = null,
        private readonly ?string $webhookUrl = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/enrich';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'findEmail' => $this->findEmail,
            'verifyEmail' => $this->verifyEmail,
            'linkedinEnrichment' => $this->linkedinEnrichment,
            'email' => $this->email,
            'linkedinUrl' => $this->linkedinUrl,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'companyDomain' => $this->companyDomain,
            'companyName' => $this->companyName,
            'jobTitle' => $this->jobTitle,
            'findPhone' => $this->findPhone,
            'webhookUrl' => $this->webhookUrl,
        ]);
    }
}
