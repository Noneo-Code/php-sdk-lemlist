<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Tasks;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create Task — `POST /tasks`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class CreateTask extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param array<string, mixed>|null $taskData
     * @param list<string>|null         $images
     * @param list<string>|null         $videos
     */
    public function __construct(
        private readonly string $type,
        private readonly string $assignedTo,
        private readonly \DateTimeInterface|string $dueDate,
        private readonly ?string $recordId = null,
        private readonly ?string $leadId = null,
        private readonly ?string $title = null,
        private readonly ?string $message = null,
        private readonly ?array $taskData = null,
        private readonly ?string $priority = null,
        private readonly ?array $images = null,
        private readonly ?array $videos = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/tasks';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'type' => $this->type,
            'assignedTo' => $this->assignedTo,
            'dueDate' => $this->dueDate,
            'recordId' => $this->recordId,
            'leadId' => $this->leadId,
            'title' => $this->title,
            'message' => $this->message,
            'taskData' => $this->taskData,
            'priority' => $this->priority,
            'images' => $this->images,
            'videos' => $this->videos,
        ]);
    }
}
