<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Sequences;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update Condition Branch — `PATCH /sequences/{sequenceId}/steps/{stepId}/branches/{branchSequenceId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateConditionBranch extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param list<string>|null $emailStatusFilter
     * @param list<string>|null $callStatusFilter
     */
    public function __construct(
        private readonly string $sequenceId,
        private readonly string $stepId,
        private readonly string $branchSequenceId,
        private readonly ?string $name = null,
        private readonly ?string $delayType = null,
        private readonly ?int $delayValue = null,
        private readonly ?string $scoreComparator = null,
        private readonly ?int $scoreThreshold = null,
        private readonly ?array $emailStatusFilter = null,
        private readonly ?array $callStatusFilter = null,
        private readonly ?string $customField = null,
        private readonly ?string $customOperator = null,
        private readonly ?string $customValue = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/sequences/'.rawurlencode($this->sequenceId).'/steps/'.rawurlencode($this->stepId).'/branches/'.rawurlencode($this->branchSequenceId);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'delayType' => $this->delayType,
            'delay' => $this->delayValue,
            'scoreComparator' => $this->scoreComparator,
            'scoreThreshold' => $this->scoreThreshold,
            'emailStatusFilter' => $this->emailStatusFilter,
            'callStatusFilter' => $this->callStatusFilter,
            'customField' => $this->customField,
            'customOperator' => $this->customOperator,
            'customValue' => $this->customValue,
        ]);
    }
}
