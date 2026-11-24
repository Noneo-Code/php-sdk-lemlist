<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Sequences;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete A/B Test Variant — `DELETE /sequences/{sequenceId}/steps/{stepId}/ab-test`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DeleteABTestVariant extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $sequenceId,
        private readonly string $stepId,
        private readonly ?string $variant = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/sequences/'.rawurlencode($this->sequenceId).'/steps/'.rawurlencode($this->stepId).'/ab-test';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'variant' => $this->variant,
        ]);
    }
}
