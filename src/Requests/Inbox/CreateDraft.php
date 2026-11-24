<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Inbox;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create Draft — `POST /inbox/{contactId}/drafts`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class CreateDraft extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string>|null               $cc
     * @param list<array<string, mixed>>|null $attachments
     * @param array<string, mixed>|null       $sourceMetadata
     */
    public function __construct(
        private readonly string $contactId,
        private readonly string $channel,
        private readonly string $content,
        private readonly string $draftOwner,
        private readonly ?string $subject = null,
        private readonly ?array $cc = null,
        private readonly ?array $attachments = null,
        private readonly ?string $replyToActivityId = null,
        private readonly ?array $sourceMetadata = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/inbox/'.rawurlencode($this->contactId).'/drafts';
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
            'channel' => $this->channel,
            'content' => $this->content,
            'subject' => $this->subject,
            'cc' => $this->cc,
            'attachments' => $this->attachments,
            'replyToActivityId' => $this->replyToActivityId,
            'sourceMetadata' => $this->sourceMetadata,
        ]);
    }
}
