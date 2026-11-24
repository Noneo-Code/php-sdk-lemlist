<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Sequences;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Reorder Condition Branches — `PATCH /sequences/{sequenceId}/steps/{stepId}/branches`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ReorderConditionBranches extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param list<string> $order
     */
    public function __construct(
        private readonly string $sequenceId,
        private readonly string $stepId,
        private readonly array $order,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/sequences/'.rawurlencode($this->sequenceId).'/steps/'.rawurlencode($this->stepId).'/branches';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'order' => $this->order,
        ]);
    }
}
