<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Inbox;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete Draft — `DELETE /inbox/{contactId}/drafts/{draftId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DeleteDraft extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $contactId,
        private readonly string $draftId,
        private readonly string $draftOwner,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/inbox/'.rawurlencode($this->contactId).'/drafts/'.rawurlencode($this->draftId);
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
