<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Domains;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Search Domains — `POST /domains-core/search`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class SearchDomains extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $base,
        private readonly ?bool $includeSuggestions = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/domains-core/search';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'base' => $this->base,
            'includeSuggestions' => $this->includeSuggestions,
        ]);
    }
}
