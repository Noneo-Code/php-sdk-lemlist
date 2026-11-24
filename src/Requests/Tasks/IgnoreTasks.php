<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Tasks;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Ignore Tasks — `POST /tasks/ignore`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class IgnoreTasks extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string> $ids
     */
    public function __construct(private readonly array $ids)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/tasks/ignore';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'ids' => $this->ids,
        ]);
    }
}
