<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `StepPersonalization` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class StepPersonalizationDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $leadId = null,
        public ?string $stepId = null,
        public ?string $variant = null,
        public ?string $emailTemplateId = null,
        public ?StepPersonalizationContentDto $content = null,
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
            leadId: Cast::string($data['leadId'] ?? null),
            stepId: Cast::string($data['stepId'] ?? null),
            variant: Cast::string($data['variant'] ?? null),
            emailTemplateId: Cast::string($data['emailTemplateId'] ?? null),
            content: Cast::object($data['content'] ?? null, StepPersonalizationContentDto::fromArray(...)),
            raw: $data,
        );
    }
}
