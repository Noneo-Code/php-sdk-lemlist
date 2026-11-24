<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Snippets;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Snippet — `GET /snippets/{snippetId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetSnippet extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $snippetId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/snippets/'.rawurlencode($this->snippetId);
    }
}
