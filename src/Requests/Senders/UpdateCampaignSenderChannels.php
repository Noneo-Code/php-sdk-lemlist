<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Senders;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update Campaign Sender Channels — `PATCH /campaigns/{campaignId}/senders/{userId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateCampaignSenderChannels extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param list<array<string, mixed>> $channels
     */
    public function __construct(
        private readonly string $campaignId,
        private readonly string $userId,
        private readonly array $channels,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/senders/'.rawurlencode($this->userId);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'channels' => $this->channels,
        ]);
    }
}
