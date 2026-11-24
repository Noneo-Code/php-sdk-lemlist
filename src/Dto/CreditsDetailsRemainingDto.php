<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `Credits.details.remaining` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class CreditsDetailsRemainingDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?int $total = null,
        public ?int $freemium = null,
        public ?int $subscription = null,
        public ?int $gifted = null,
        public ?int $paid = null,
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
            total: Cast::int($data['total'] ?? null),
            freemium: Cast::int($data['freemium'] ?? null),
            subscription: Cast::int($data['subscription'] ?? null),
            gifted: Cast::int($data['gifted'] ?? null),
            paid: Cast::int($data['paid'] ?? null),
            raw: $data,
        );
    }
}
