<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Tasks;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update Task — `PATCH /tasks`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateTask extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param list<string>|null $images
     * @param list<string>|null $videos
     */
    public function __construct(
        private readonly string $id,
        private readonly ?string $assignedTo = null,
        private readonly \DateTimeInterface|string|null $dueDate = null,
        private readonly ?string $title = null,
        private readonly ?string $message = null,
        private readonly ?string $priority = null,
        private readonly ?bool $done = null,
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
            'id' => $this->id,
            'assignedTo' => $this->assignedTo,
            'dueDate' => $this->dueDate,
            'title' => $this->title,
            'message' => $this->message,
            'priority' => $this->priority,
            'done' => $this->done,
            'images' => $this->images,
            'videos' => $this->videos,
        ]);
    }
}
