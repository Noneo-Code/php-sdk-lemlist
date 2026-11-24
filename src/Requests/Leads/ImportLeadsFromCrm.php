<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Leads;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Import Leads from CRM — `POST /campaigns/{campaignId}/leads/import`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ImportLeadsFromCrm extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param string|list<string>|null $enrichFeature
     */
    public function __construct(
        private readonly string $campaignId,
        private readonly mixed $filterId,
        private readonly ?string $filterType = null,
        private readonly ?string $userId = null,
        private readonly mixed $deduplicate = null,
        private readonly string|array|null $enrichFeature = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/leads/import';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'filterId' => $this->filterId,
            'filterType' => $this->filterType,
            'userId' => $this->userId,
            'deduplicate' => $this->deduplicate,
            'enrichFeature' => $this->enrichFeature,
        ]);
    }
}
