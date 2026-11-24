<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Contacts;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Add or Remove Contacts in a List — `POST /contacts/lists/{listId}/entities`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class AddOrRemoveContactsInAList extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string> $contactIds
     */
    public function __construct(
        private readonly string $listId,
        private readonly array $contactIds,
        private readonly ?string $action = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/contacts/lists/'.rawurlencode($this->listId).'/entities';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'action' => $this->action,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'contactIds' => $this->contactIds,
        ]);
    }
}
