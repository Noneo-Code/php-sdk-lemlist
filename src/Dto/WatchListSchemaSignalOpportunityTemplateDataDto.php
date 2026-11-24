<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `WatchListSchema.signalOpportunityTemplate.data` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class WatchListSchemaSignalOpportunityTemplateDataDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $title = null,
        public ?string $subject = null,
        public ?string $emailTemplateId = null,
        public ?string $message = null,
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
            title: Cast::string($data['title'] ?? null),
            subject: Cast::string($data['subject'] ?? null),
            emailTemplateId: Cast::string($data['emailTemplateId'] ?? null),
            message: Cast::string($data['message'] ?? null),
            raw: $data,
        );
    }
}
