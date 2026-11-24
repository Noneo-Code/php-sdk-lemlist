<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `SenderPictureStatusResponse.data` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class SenderPictureStatusResponseDataDto
{
    /**
     * @param list<SenderPictureMailboxDto>|null $mailboxes
     * @param array<array-key, mixed>            $raw       corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $userId = null,
        public ?bool $hasPicture = null,
        public ?array $mailboxes = null,
        public ?SenderPictureStatusResponseDataCountsDto $counts = null,
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
            userId: Cast::string($data['userId'] ?? null),
            hasPicture: Cast::bool($data['hasPicture'] ?? null),
            mailboxes: Cast::objects($data['mailboxes'] ?? null, SenderPictureMailboxDto::fromArray(...)),
            counts: Cast::object($data['counts'] ?? null, SenderPictureStatusResponseDataCountsDto::fromArray(...)),
            raw: $data,
        );
    }
}
