<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Sequences;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get A/B Test Variant — `GET /sequences/{sequenceId}/steps/{stepId}/ab-test`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetABTestVariant extends Request
{
    protected Method $method = Method::GET;

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
