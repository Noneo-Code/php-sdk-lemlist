<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Inbox;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List Drafts — `GET /inbox/{contactId}/drafts`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListDrafts extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $contactId,
        private readonly string $draftOwner,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/inbox/'.rawurlencode($this->contactId).'/drafts';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'draftOwner' => $this->draftOwner,
        ]);
    }
}
