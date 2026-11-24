<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `MessageTemplateListResponse` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class MessageTemplateListResponseDto
{
    /**
     * @param list<MessageTemplateDto>|null $data
     * @param array<array-key, mixed>       $raw  corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?array $data = null,
        public ?PageMetaDto $meta = null,
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
            data: Cast::objects($data['data'] ?? null, MessageTemplateDto::fromArray(...)),
            meta: Cast::object($data['meta'] ?? null, PageMetaDto::fromArray(...)),
            raw: $data,
        );
    }
}
