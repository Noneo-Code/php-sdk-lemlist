<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `User.linkedIn` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class UserLinkedInDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $linkedinUrl = null,
        public ?bool $status = null,
        public ?int $followLimit = null,
        public ?int $inviteLimit = null,
        public ?int $sendLimit = null,
        public ?int $visitLimit = null,
        public ?int $inMailLimit = null,
        public ?int $networkCheckLimit = null,
        public ?int $withdrawInvitationLimit = null,
        public ?int $likeLastPostLimit = null,
        public ?int $endorseLimit = null,
        public ?int $commentLastPostRetrieveLimit = null,
        public ?int $commentLastPostSendLimit = null,
        public ?int $inviteRampUp = null,
        public array $raw = [],
    ) {
    }

    /**
     * Toute valeur absente ou d'un type inattendu devient `null` ; elle reste
     * lisible dans `raw`.
     *
     * @param array<array-key, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            linkedinUrl: Cast::string($data['linkedinUrl'] ?? null),
            status: Cast::bool($data['status'] ?? null),
            followLimit: Cast::int($data['followLimit'] ?? null),
            inviteLimit: Cast::int($data['inviteLimit'] ?? null),
            sendLimit: Cast::int($data['sendLimit'] ?? null),
            visitLimit: Cast::int($data['visitLimit'] ?? null),
            inMailLimit: Cast::int($data['inMailLimit'] ?? null),
            networkCheckLimit: Cast::int($data['networkCheckLimit'] ?? null),
            withdrawInvitationLimit: Cast::int($data['withdrawInvitationLimit'] ?? null),
            likeLastPostLimit: Cast::int($data['likeLastPostLimit'] ?? null),
            endorseLimit: Cast::int($data['endorseLimit'] ?? null),
            commentLastPostRetrieveLimit: Cast::int($data['commentLastPostRetrieveLimit'] ?? null),
            commentLastPostSendLimit: Cast::int($data['commentLastPostSendLimit'] ?? null),
            inviteRampUp: Cast::int($data['inviteRampUp'] ?? null),
            raw: $data,
        );
    }
}
