<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Inbox;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Attach Labels to Conversations — `POST /inbox/conversations/labels/{contactId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class AttachLabelsToConversations extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string> $labelIds
     */
    public function __construct(
        private readonly string $contactId,
        private readonly array $labelIds,
        private readonly bool $appendLabels,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/inbox/conversations/labels/'.rawurlencode($this->contactId);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'labelIds' => $this->labelIds,
            'appendLabels' => $this->appendLabels,
        ]);
    }
}
