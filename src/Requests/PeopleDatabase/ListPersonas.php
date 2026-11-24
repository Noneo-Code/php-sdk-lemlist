<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\PeopleDatabase;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List Personas — `GET /database/personas`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListPersonas extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly ?string $mode = null)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/database/personas';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'mode' => $this->mode,
        ]);
    }
}
