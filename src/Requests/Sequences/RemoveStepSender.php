<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Sequences;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Remove Step Sender — `DELETE /sequences/{sequenceId}/steps/{stepId}/sender`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class RemoveStepSender extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $sequenceId,
        private readonly string $stepId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/sequences/'.rawurlencode($this->sequenceId).'/steps/'.rawurlencode($this->stepId).'/sender';
    }
}
