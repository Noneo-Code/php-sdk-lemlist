<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\ContactSourcing;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Contact Sourcing Run — `GET /contact-sourcing`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetContactSourcingRun extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $runId = null,
        private readonly ?string $companyId = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/contact-sourcing';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'runId' => $this->runId,
            'companyId' => $this->companyId,
        ]);
    }
}
