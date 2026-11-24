<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `ExternalSignalPushResponse` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class ExternalSignalPushResponseDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $status = null,
        public ?string $signalId = null,
        public ?string $reason = null,
        public ?int $creditsConsumed = null,
        public ?ExternalSignalPushResponseEntityDto $entity = null,
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
            status: Cast::string($data['status'] ?? null),
            signalId: Cast::string($data['signalId'] ?? null),
            reason: Cast::string($data['reason'] ?? null),
            creditsConsumed: Cast::int($data['creditsConsumed'] ?? null),
            entity: Cast::object($data['entity'] ?? null, ExternalSignalPushResponseEntityDto::fromArray(...)),
            raw: $data,
        );
    }
}
