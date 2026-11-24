<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Contacts;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create Contact List — `POST /contacts/lists`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class CreateContactList extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(private readonly string $name)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/contacts/lists';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
        ]);
    }
}
