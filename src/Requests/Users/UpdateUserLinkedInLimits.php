<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Users;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update User LinkedIn Limits — `PATCH /users/{userId}/linkedin-limits`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateUserLinkedInLimits extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        private readonly string $userId,
        private readonly ?int $followLimit = null,
        private readonly ?int $inviteLimit = null,
        private readonly ?int $sendLimit = null,
        private readonly ?int $visitLimit = null,
        private readonly ?int $inMailLimit = null,
        private readonly ?int $networkCheckLimit = null,
        private readonly ?int $withdrawInvitationLimit = null,
        private readonly ?int $likeLastPostLimit = null,
        private readonly ?int $endorseLimit = null,
        private readonly ?int $commentLastPostRetrieveLimit = null,
        private readonly ?int $commentLastPostSendLimit = null,
        private readonly ?int $inviteRampUp = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/users/'.rawurlencode($this->userId).'/linkedin-limits';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'followLimit' => $this->followLimit,
            'inviteLimit' => $this->inviteLimit,
            'sendLimit' => $this->sendLimit,
            'visitLimit' => $this->visitLimit,
            'inMailLimit' => $this->inMailLimit,
            'networkCheckLimit' => $this->networkCheckLimit,
            'withdrawInvitationLimit' => $this->withdrawInvitationLimit,
            'likeLastPostLimit' => $this->likeLastPostLimit,
            'endorseLimit' => $this->endorseLimit,
            'commentLastPostRetrieveLimit' => $this->commentLastPostRetrieveLimit,
            'commentLastPostSendLimit' => $this->commentLastPostSendLimit,
            'inviteRampUp' => $this->inviteRampUp,
        ]);
    }
}
