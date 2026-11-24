<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Inbox;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update Draft — `PATCH /inbox/{contactId}/drafts/{draftId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateDraft extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param list<string>|null               $cc
     * @param list<array<string, mixed>>|null $attachments
     */
    public function __construct(
        private readonly string $contactId,
        private readonly string $draftId,
        private readonly string $draftOwner,
        private readonly ?string $subject = null,
        private readonly ?array $cc = null,
        private readonly ?string $content = null,
        private readonly ?array $attachments = null,
        private readonly ?string $replyToActivityId = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/inbox/'.rawurlencode($this->contactId).'/drafts/'.rawurlencode($this->draftId);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'draftOwner' => $this->draftOwner,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'subject' => $this->subject,
            'cc' => $this->cc,
            'content' => $this->content,
            'attachments' => $this->attachments,
            'replyToActivityId' => $this->replyToActivityId,
        ]);
    }
}
