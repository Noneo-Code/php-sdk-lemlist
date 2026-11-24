<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Tasks;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Search Tasks — `GET /v2/tasks`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class SearchTasks extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $taskId = null,
        private readonly ?string $contactId = null,
        private readonly ?string $contactIdNot = null,
        private readonly ?string $companyId = null,
        private readonly ?string $companyIdNot = null,
        private readonly ?string $leadId = null,
        private readonly ?string $leadIdNot = null,
        private readonly ?string $campaignId = null,
        private readonly ?string $campaignIdNot = null,
        private readonly ?string $assignedTo = null,
        private readonly ?string $assignedToNot = null,
        private readonly ?string $objectType = null,
        private readonly ?string $type = null,
        private readonly ?string $typeNot = null,
        private readonly ?string $channel = null,
        private readonly ?string $status = null,
        private readonly ?string $priority = null,
        private readonly ?string $title = null,
        private readonly ?string $contactLinkedinUrl = null,
        private readonly \DateTimeInterface|string|null $dueDateFrom = null,
        private readonly \DateTimeInterface|string|null $dueDateTo = null,
        private readonly \DateTimeInterface|string|null $completedAtFrom = null,
        private readonly \DateTimeInterface|string|null $completedAtTo = null,
        private readonly ?bool $hasCampaign = null,
        private readonly ?bool $hasDueDate = null,
        private readonly ?string $search = null,
        private readonly ?string $advancedFilters = null,
        private readonly ?string $include = null,
        private readonly ?string $sortBy = null,
        private readonly ?string $sortOrder = null,
        private readonly ?int $page = null,
        private readonly ?int $limit = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/tasks';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'taskId' => $this->taskId,
            'contactId' => $this->contactId,
            'contactIdNot' => $this->contactIdNot,
            'companyId' => $this->companyId,
            'companyIdNot' => $this->companyIdNot,
            'leadId' => $this->leadId,
            'leadIdNot' => $this->leadIdNot,
            'campaignId' => $this->campaignId,
            'campaignIdNot' => $this->campaignIdNot,
            'assignedTo' => $this->assignedTo,
            'assignedToNot' => $this->assignedToNot,
            'objectType' => $this->objectType,
            'type' => $this->type,
            'typeNot' => $this->typeNot,
            'channel' => $this->channel,
            'status' => $this->status,
            'priority' => $this->priority,
            'title' => $this->title,
            'contactLinkedinUrl' => $this->contactLinkedinUrl,
            'dueDateFrom' => $this->dueDateFrom,
            'dueDateTo' => $this->dueDateTo,
            'completedAtFrom' => $this->completedAtFrom,
            'completedAtTo' => $this->completedAtTo,
            'hasCampaign' => $this->hasCampaign,
            'hasDueDate' => $this->hasDueDate,
            'search' => $this->search,
            'advancedFilters' => $this->advancedFilters,
            'include' => $this->include,
            'sortBy' => $this->sortBy,
            'sortOrder' => $this->sortOrder,
            'page' => $this->page,
            'limit' => $this->limit,
        ]);
    }
}
