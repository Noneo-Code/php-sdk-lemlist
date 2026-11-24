<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `Company.fields` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class CompanyFieldsDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?float $accountPenetration = null,
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
            accountPenetration: Cast::float($data['accountPenetration'] ?? null),
            raw: $data,
        );
    }
}
