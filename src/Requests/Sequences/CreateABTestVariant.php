<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Sequences;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Create A/B Test Variant — `POST /sequences/{sequenceId}/steps/{stepId}/ab-test`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class CreateABTestVariant extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $sequenceId,
        private readonly string $stepId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/sequences/'.rawurlencode($this->sequenceId).'/steps/'.rawurlencode($this->stepId).'/ab-test';
    }
}
