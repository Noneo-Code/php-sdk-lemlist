<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `SenderPictureSyncResponse.data` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class SenderPictureSyncResponseDataDto
{
    /**
     * @param list<SenderPictureSyncResponseDataMailboxesItemDto>|null $mailboxes
     * @param array<array-key, mixed>                                  $raw       corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?int $enqueued = null,
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
            enqueued: Cast::int($data['enqueued'] ?? null),
            mailboxes: Cast::objects($data['mailboxes'] ?? null, SenderPictureSyncResponseDataMailboxesItemDto::fromArray(...)),
            raw: $data,
        );
    }
}
