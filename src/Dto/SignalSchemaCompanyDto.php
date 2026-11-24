<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `SignalSchema.company` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class SignalSchemaCompanyDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?string $name = null,
        public ?string $domain = null,
        public ?string $linkedinUrl = null,
        public ?string $industry = null,
        public ?string $picture = null,
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
            domain: Cast::string($data['domain'] ?? null),
            linkedinUrl: Cast::string($data['linkedinUrl'] ?? null),
            industry: Cast::string($data['industry'] ?? null),
            picture: Cast::string($data['picture'] ?? null),
            raw: $data,
        );
    }
}
