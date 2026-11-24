<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Campaigns;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Many Campaigns — `GET /campaigns`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetManyCampaigns extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?int $offset = null,
        private readonly ?int $limit = null,
        private readonly ?string $version = null,
        private readonly ?int $page = null,
        private readonly ?string $sortBy = null,
        private readonly ?string $sortOrder = null,
        private readonly ?string $status = null,
        private readonly ?string $createdBy = null,
        private readonly ?string $folderId = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'offset' => $this->offset,
            'limit' => $this->limit,
            'version' => $this->version,
            'page' => $this->page,
            'sortBy' => $this->sortBy,
            'sortOrder' => $this->sortOrder,
            'status' => $this->status,
            'createdBy' => $this->createdBy,
            'folderId' => $this->folderId,
        ]);
    }
}
