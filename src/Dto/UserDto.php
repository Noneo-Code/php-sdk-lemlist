<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `User` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class UserDto
{
    /**
     * @param list<MailboxDto>|null   $mailboxes
     * @param array<array-key, mixed> $raw       corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?string $email = null,
        public ?string $role = null,
        public ?UserLinkedInDto $linkedIn = null,
        public ?array $mailboxes = null,
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
            email: Cast::string($data['email'] ?? null),
            role: Cast::string($data['role'] ?? null),
            linkedIn: Cast::object($data['linkedIn'] ?? null, UserLinkedInDto::fromArray(...)),
            mailboxes: Cast::objects($data['mailboxes'] ?? null, MailboxDto::fromArray(...)),
            raw: $data,
        );
    }
}
