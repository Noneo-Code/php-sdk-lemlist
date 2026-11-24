<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `SenderPictureMailbox` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class SenderPictureMailboxDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $mailboxId = null,
        public ?string $email = null,
        public ?string $provider = null,
        public ?string $status = null,
        public ?\DateTimeImmutable $syncedAt = null,
        public ?string $lastError = null,
        public ?bool $hasOverride = null,
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
            mailboxId: Cast::string($data['mailboxId'] ?? null),
            email: Cast::string($data['email'] ?? null),
            provider: Cast::string($data['provider'] ?? null),
            status: Cast::string($data['status'] ?? null),
            syncedAt: Cast::dateTime($data['syncedAt'] ?? null),
            lastError: Cast::string($data['lastError'] ?? null),
            hasOverride: Cast::bool($data['hasOverride'] ?? null),
            raw: $data,
        );
    }
}
