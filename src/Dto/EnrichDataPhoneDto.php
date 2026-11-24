<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `Enrich.data.phone` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class EnrichDataPhoneDto
{
    /**
     * @param list<string>|null       $additionalPhones
     * @param array<array-key, mixed> $raw              corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $phone = null,
        public ?array $additionalPhones = null,
        public ?bool $notFound = null,
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
            phone: Cast::string($data['phone'] ?? null),
            additionalPhones: Cast::strings($data['additionalPhones'] ?? null),
            notFound: Cast::bool($data['notFound'] ?? null),
            raw: $data,
        );
    }
}
