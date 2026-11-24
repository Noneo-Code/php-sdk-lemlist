<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Companies;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Merge Companies — `POST /companies/merge`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class MergeCompanies extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string> $secondaryIds
     */
    public function __construct(
        private readonly string $primaryId,
        private readonly array $secondaryIds,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/companies/merge';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'primaryId' => $this->primaryId,
            'secondaryIds' => $this->secondaryIds,
        ]);
    }
}
