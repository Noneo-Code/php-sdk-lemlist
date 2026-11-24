<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Companies;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Add and update company — `POST /companies`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class AddAndUpdateCompany extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param array<string, mixed> $additional
     */
    public function __construct(
        private readonly ?string $companyId = null,
        private readonly ?string $name = null,
        private readonly ?string $domain = null,
        private readonly ?string $linkedinUrl = null,
        private readonly ?string $linkedinUrlSalesNav = null,
        private readonly ?string $companyOwner = null,
        private readonly ?string $industry = null,
        private readonly ?string $location = null,
        private readonly ?string $size = null,
        private readonly ?string $specialties = null,
        private readonly ?string $tagline = null,
        private readonly ?string $type = null,
        private readonly ?string $description = null,
        private readonly ?string $foundedOn = null,
        private readonly ?string $headquarters = null,
        private readonly ?string $picture = null,
        private readonly ?string $source = null,
        private readonly ?string $crmId = null,
        private readonly ?string $updateStrategy = null,
        private readonly array $additional = [],
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/companies';
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
            'companyId' => $this->companyId,
            'name' => $this->name,
            'domain' => $this->domain,
            'linkedinUrl' => $this->linkedinUrl,
            'linkedinUrlSalesNav' => $this->linkedinUrlSalesNav,
            'companyOwner' => $this->companyOwner,
            'industry' => $this->industry,
            'location' => $this->location,
            'size' => $this->size,
            'specialties' => $this->specialties,
            'tagline' => $this->tagline,
            'type' => $this->type,
            'description' => $this->description,
            'foundedOn' => $this->foundedOn,
            'headquarters' => $this->headquarters,
            'picture' => $this->picture,
            'source' => $this->source,
            'crmId' => $this->crmId,
        ], $this->additional);
    }
}
