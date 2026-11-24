<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\MessageTemplates;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List Message Templates — `GET /message-templates`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListMessageTemplates extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $search = null,
        private readonly ?string $tags = null,
        private readonly ?string $userIds = null,
        private readonly ?int $page = null,
        private readonly ?int $limit = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/message-templates';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'search' => $this->search,
            'tags' => $this->tags,
            'userIds' => $this->userIds,
            'page' => $this->page,
            'limit' => $this->limit,
        ]);
    }
}
