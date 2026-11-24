<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\MessageTemplates;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List Message Template Tags — `GET /message-templates/tags`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListMessageTemplateTags extends Request
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
        return '/message-templates/tags';
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
