<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Sequences;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete Condition Branch — `DELETE /sequences/{sequenceId}/steps/{stepId}/branches/{branchSequenceId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DeleteConditionBranch extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $sequenceId,
        private readonly string $stepId,
        private readonly string $branchSequenceId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/sequences/'.rawurlencode($this->sequenceId).'/steps/'.rawurlencode($this->stepId).'/branches/'.rawurlencode($this->branchSequenceId);
    }
}
