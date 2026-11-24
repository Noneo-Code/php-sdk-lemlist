<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `Enrich.data` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class EnrichDataDto
{
    /**
     * @param array<array-key, mixed>|null $linkedin
     * @param array<array-key, mixed>      $raw      corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?EnrichDataEmailDto $email = null,
        public ?EnrichDataPhoneDto $phone = null,
        public ?array $linkedin = null,
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
            email: Cast::object($data['email'] ?? null, EnrichDataEmailDto::fromArray(...)),
            phone: Cast::object($data['phone'] ?? null, EnrichDataPhoneDto::fromArray(...)),
            linkedin: Cast::map($data['linkedin'] ?? null),
            raw: $data,
        );
    }
}
