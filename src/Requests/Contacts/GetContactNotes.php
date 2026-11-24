<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Contacts;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Contact Notes — `GET /contacts/{idOrEmail}/notes`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetContactNotes extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $idOrEmail,
        private readonly ?int $limit = null,
        private readonly ?int $page = null,
        private readonly ?string $sortBy = null,
        private readonly ?string $sortOrder = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/contacts/'.rawurlencode($this->idOrEmail).'/notes';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'limit' => $this->limit,
            'page' => $this->page,
            'sortBy' => $this->sortBy,
            'sortOrder' => $this->sortOrder,
        ]);
    }
}
