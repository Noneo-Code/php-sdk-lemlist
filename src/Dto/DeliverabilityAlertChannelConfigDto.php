<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `DeliverabilityAlert.channelConfig` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class DeliverabilityAlertChannelConfigDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?DeliverabilityAlertChannelConfigEmailDto $email = null,
        public ?DeliverabilityAlertChannelConfigInappDto $inapp = null,
        public ?DeliverabilityAlertChannelConfigWebhookDto $webhook = null,
        public ?DeliverabilityAlertChannelConfigSlackDto $slack = null,
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
            email: Cast::object($data['email'] ?? null, DeliverabilityAlertChannelConfigEmailDto::fromArray(...)),
            inapp: Cast::object($data['inapp'] ?? null, DeliverabilityAlertChannelConfigInappDto::fromArray(...)),
            webhook: Cast::object($data['webhook'] ?? null, DeliverabilityAlertChannelConfigWebhookDto::fromArray(...)),
            slack: Cast::object($data['slack'] ?? null, DeliverabilityAlertChannelConfigSlackDto::fromArray(...)),
            raw: $data,
        );
    }
}
