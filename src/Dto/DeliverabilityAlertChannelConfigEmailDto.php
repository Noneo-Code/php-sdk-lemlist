<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `DeliverabilityAlert.channelConfig.email` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class DeliverabilityAlertChannelConfigEmailDto
{
    /**
     * @param list<string>|null       $addresses
     * @param array<array-key, mixed> $raw       corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?bool $enabled = null,
        public ?array $addresses = null,
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
            enabled: Cast::bool($data['enabled'] ?? null),
            addresses: Cast::strings($data['addresses'] ?? null),
            raw: $data,
        );
    }
}
