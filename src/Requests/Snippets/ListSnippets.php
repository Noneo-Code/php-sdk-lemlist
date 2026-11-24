<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Snippets;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List Snippets — `GET /snippets`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListSnippets extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $search = null,
        private readonly ?string $userIds = null,
        private readonly ?int $page = null,
        private readonly ?int $limit = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/snippets';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'search' => $this->search,
            'userIds' => $this->userIds,
            'page' => $this->page,
            'limit' => $this->limit,
        ]);
    }
}
