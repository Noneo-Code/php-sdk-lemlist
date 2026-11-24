<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `StepPersonalization.content` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class StepPersonalizationContentDto
{
    /**
     * @param list<string>|null       $cc
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $subject = null,
        public ?string $message = null,
        public ?array $cc = null,
        public ?bool $plainText = null,
        public ?string $altMessage = null,
        public ?string $altMessagePremium = null,
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
            subject: Cast::string($data['subject'] ?? null),
            message: Cast::string($data['message'] ?? null),
            cc: Cast::strings($data['cc'] ?? null),
            plainText: Cast::bool($data['plainText'] ?? null),
            altMessage: Cast::string($data['altMessage'] ?? null),
            altMessagePremium: Cast::string($data['altMessagePremium'] ?? null),
            raw: $data,
        );
    }
}
