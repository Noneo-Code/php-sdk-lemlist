<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Sequences;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Select A/B Test Winner — `POST /sequences/{sequenceId}/steps/{stepId}/ab-test/winner`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class SelectABTestWinner extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $sequenceId,
        private readonly string $stepId,
        private readonly string $variant,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/sequences/'.rawurlencode($this->sequenceId).'/steps/'.rawurlencode($this->stepId).'/ab-test/winner';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'variant' => $this->variant,
        ]);
    }
}
