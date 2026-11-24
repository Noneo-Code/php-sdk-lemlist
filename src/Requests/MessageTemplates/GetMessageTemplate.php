<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\MessageTemplates;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Message Template — `GET /message-templates/{templateId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetMessageTemplate extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $templateId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/message-templates/'.rawurlencode($this->templateId);
    }
}
