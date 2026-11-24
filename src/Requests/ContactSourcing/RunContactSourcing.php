<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\ContactSourcing;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Run Contact Sourcing — `POST /contact-sourcing`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class RunContactSourcing extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string> $companyIds
     */
    public function __construct(
        private readonly array $companyIds,
        private readonly ?bool $overwrite = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/contact-sourcing';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'companyIds' => $this->companyIds,
            'overwrite' => $this->overwrite,
        ]);
    }
}
