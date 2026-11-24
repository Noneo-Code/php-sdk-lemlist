<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `Team` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class TeamDto
{
    /**
     * @param list<string>|null                  $userIds
     * @param list<WebhookDto>|null              $hooks
     * @param list<string>|null                  $beta
     * @param list<TeamInvitedUsersItemDto>|null $invitedUsers
     * @param list<TeamUsersItemDto>|null        $users
     * @param array<array-key, mixed>            $raw          corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?string $name = null,
        public ?array $userIds = null,
        public ?string $createdBy = null,
        public ?\DateTimeImmutable $createdAt = null,
        public ?array $hooks = null,
        public ?array $beta = null,
        public ?TeamSlackWebhookDto $slackWebhook = null,
        public ?array $invitedUsers = null,
        public ?string $agency = null,
        public ?string $pictureId = null,
        public ?string $customDomain = null,
        public ?array $users = null,
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
            _id: Cast::string($data['_id'] ?? null),
            name: Cast::string($data['name'] ?? null),
            userIds: Cast::strings($data['userIds'] ?? null),
            createdBy: Cast::string($data['createdBy'] ?? null),
            createdAt: Cast::dateTime($data['createdAt'] ?? null),
            hooks: Cast::objects($data['hooks'] ?? null, WebhookDto::fromArray(...)),
            beta: Cast::strings($data['beta'] ?? null),
            slackWebhook: Cast::object($data['slackWebhook'] ?? null, TeamSlackWebhookDto::fromArray(...)),
            invitedUsers: Cast::objects($data['invitedUsers'] ?? null, TeamInvitedUsersItemDto::fromArray(...)),
            agency: Cast::string($data['agency'] ?? null),
            pictureId: Cast::string($data['pictureId'] ?? null),
            customDomain: Cast::string($data['customDomain'] ?? null),
            users: Cast::objects($data['users'] ?? null, TeamUsersItemDto::fromArray(...)),
            raw: $data,
        );
    }
}
