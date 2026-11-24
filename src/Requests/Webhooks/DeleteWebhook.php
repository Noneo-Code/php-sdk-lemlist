<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Webhooks;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete Webhook — `DELETE /hooks/{hookId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DeleteWebhook extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(private readonly string $hookId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/hooks/'.rawurlencode($this->hookId);
    }
}
