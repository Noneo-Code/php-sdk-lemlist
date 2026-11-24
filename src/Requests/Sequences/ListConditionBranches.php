<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Sequences;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List Condition Branches — `GET /sequences/{sequenceId}/steps/{stepId}/branches`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListConditionBranches extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $sequenceId,
        private readonly string $stepId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/sequences/'.rawurlencode($this->sequenceId).'/steps/'.rawurlencode($this->stepId).'/branches';
    }
}
