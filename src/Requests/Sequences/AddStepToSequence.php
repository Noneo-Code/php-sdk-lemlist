<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Sequences;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Add Step to Sequence — `POST /sequences/{sequenceId}/steps`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class AddStepToSequence extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string>|null $images
     * @param list<string>|null $videos
     * @param list<string>|null $workflowIds
     */
    public function __construct(
        private readonly string $sequenceId,
        private readonly ?string $type = null,
        private readonly ?int $index = null,
        private readonly ?int $delayValue = null,
        private readonly ?string $subject = null,
        private readonly ?string $message = null,
        private readonly ?string $altMessage = null,
        private readonly ?string $altMessagePremium = null,
        private readonly ?string $customName = null,
        private readonly ?string $title = null,
        private readonly ?bool $manual = null,
        private readonly ?int $priority = null,
        private readonly ?string $methodValue = null,
        private readonly ?string $url = null,
        private readonly ?string $conditionKey = null,
        private readonly ?string $delayType = null,
        private readonly ?string $customField = null,
        private readonly ?string $customOperator = null,
        private readonly ?string $customValue = null,
        private readonly ?string $campaignId = null,
        private readonly ?string $leadAction = null,
        private readonly ?string $endLeadStatus = null,
        private readonly ?array $images = null,
        private readonly ?array $videos = null,
        private readonly ?string $skillName = null,
        private readonly ?bool $endorseAnyFallback = null,
        private readonly ?string $recordMode = null,
        private readonly ?array $workflowIds = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/sequences/'.rawurlencode($this->sequenceId).'/steps';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'type' => $this->type,
            'index' => $this->index,
            'delay' => $this->delayValue,
            'subject' => $this->subject,
            'message' => $this->message,
            'altMessage' => $this->altMessage,
            'altMessagePremium' => $this->altMessagePremium,
            'customName' => $this->customName,
            'title' => $this->title,
            'manual' => $this->manual,
            'priority' => $this->priority,
            'method' => $this->methodValue,
            'url' => $this->url,
            'conditionKey' => $this->conditionKey,
            'delayType' => $this->delayType,
            'customField' => $this->customField,
            'customOperator' => $this->customOperator,
            'customValue' => $this->customValue,
            'campaignId' => $this->campaignId,
            'leadAction' => $this->leadAction,
            'endLeadStatus' => $this->endLeadStatus,
            'images' => $this->images,
            'videos' => $this->videos,
            'skillName' => $this->skillName,
            'endorseAnyFallback' => $this->endorseAnyFallback,
            'recordMode' => $this->recordMode,
            'workflowIds' => $this->workflowIds,
        ]);
    }
}
