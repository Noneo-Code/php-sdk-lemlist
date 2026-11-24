<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `LemwarmSettings` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class LemwarmSettingsDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?bool $active = null,
        public ?int $dailyLimit = null,
        public ?string $warmupTemplate = null,
        public ?bool $warmDailyVarianceEnabled = null,
        public ?LemwarmSettingsDeliverabilityDto $deliverability = null,
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
            active: Cast::bool($data['active'] ?? null),
            dailyLimit: Cast::int($data['dailyLimit'] ?? null),
            warmupTemplate: Cast::string($data['warmupTemplate'] ?? null),
            warmDailyVarianceEnabled: Cast::bool($data['warmDailyVarianceEnabled'] ?? null),
            deliverability: Cast::object($data['deliverability'] ?? null, LemwarmSettingsDeliverabilityDto::fromArray(...)),
            raw: $data,
        );
    }
}
