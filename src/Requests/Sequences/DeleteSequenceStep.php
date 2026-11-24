<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Sequences;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete Sequence Step — `DELETE /sequences/{sequenceId}/steps/{stepId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DeleteSequenceStep extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $sequenceId,
        private readonly string $stepId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/sequences/'.rawurlencode($this->sequenceId).'/steps/'.rawurlencode($this->stepId);
    }
}
