<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Contacts;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Add and update contact — `POST /contacts`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class AddAndUpdateContact extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string>|null    $additionalEmails
     * @param array<string, mixed> $additional
     */
    public function __construct(
        private readonly ?string $contactId = null,
        private readonly ?string $email = null,
        private readonly ?string $linkedinUrl = null,
        private readonly ?string $linkedinUrlSalesNav = null,
        private readonly ?array $additionalEmails = null,
        private readonly ?string $firstName = null,
        private readonly ?string $lastName = null,
        private readonly ?string $phone = null,
        private readonly ?string $jobTitle = null,
        private readonly ?string $jobDescription = null,
        private readonly ?string $picture = null,
        private readonly ?string $timezone = null,
        private readonly ?string $industry = null,
        private readonly ?string $languages = null,
        private readonly ?string $location = null,
        private readonly ?string $skills = null,
        private readonly ?string $summary = null,
        private readonly ?string $tagline = null,
        private readonly ?string $peopleDbSeniority = null,
        private readonly ?string $peopleDbDepartment = null,
        private readonly ?string $peopleDbConnectionCount = null,
        private readonly ?string $contactOwner = null,
        private readonly ?string $source = null,
        private readonly ?string $companyId = null,
        private readonly ?string $companyDomain = null,
        private readonly ?string $companyLinkedinUrl = null,
        private readonly ?string $crmId = null,
        private readonly ?string $updateStrategy = null,
        private readonly array $additional = [],
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/contacts';
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
            'contactId' => $this->contactId,
            'email' => $this->email,
            'linkedinUrl' => $this->linkedinUrl,
            'linkedinUrlSalesNav' => $this->linkedinUrlSalesNav,
            'additionalEmails' => $this->additionalEmails,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'phone' => $this->phone,
            'jobTitle' => $this->jobTitle,
            'jobDescription' => $this->jobDescription,
            'picture' => $this->picture,
            'timezone' => $this->timezone,
            'industry' => $this->industry,
            'languages' => $this->languages,
            'location' => $this->location,
            'skills' => $this->skills,
            'summary' => $this->summary,
            'tagline' => $this->tagline,
            'peopleDbSeniority' => $this->peopleDbSeniority,
            'peopleDbDepartment' => $this->peopleDbDepartment,
            'peopleDbConnectionCount' => $this->peopleDbConnectionCount,
            'contactOwner' => $this->contactOwner,
            'source' => $this->source,
            'companyId' => $this->companyId,
            'companyDomain' => $this->companyDomain,
            'companyLinkedinUrl' => $this->companyLinkedinUrl,
            'crmId' => $this->crmId,
        ], $this->additional);
    }
}
