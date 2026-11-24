<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `WatchListApiFetchSignalsResponse` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class WatchListApiFetchSignalsResponseDto
{
    /**
     * @param list<SignalSchemaDto>|null $data
     * @param array<array-key, mixed>    $raw  corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?array $data = null,
        public ?WatchListListMetaDto $meta = null,
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
            data: Cast::objects($data['data'] ?? null, SignalSchemaDto::fromArray(...)),
            meta: Cast::object($data['meta'] ?? null, WatchListListMetaDto::fromArray(...)),
            raw: $data,
        );
    }
}
