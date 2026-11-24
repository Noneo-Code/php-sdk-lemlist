<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Contacts;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Contact Lists — `GET /contacts/lists`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetContactLists extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly ?string $search = null)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/contacts/lists';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'search' => $this->search,
        ]);
    }
}
