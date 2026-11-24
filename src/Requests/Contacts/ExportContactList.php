<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Contacts;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Export Contact List — `GET /contacts/export`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ExportContactList extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $listId,
        private readonly ?string $entity = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/contacts/export';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'listId' => $this->listId,
            'entity' => $this->entity,
        ]);
    }
}
