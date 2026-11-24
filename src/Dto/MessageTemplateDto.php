<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `MessageTemplate` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class MessageTemplateDto
{
    /**
     * @param list<string>|null       $cc
     * @param list<string>|null       $tags
     * @param array<array-key, mixed> $raw  corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?string $name = null,
        public ?string $subject = null,
        public ?string $message = null,
        public ?array $cc = null,
        public ?array $tags = null,
        public ?string $createdBy = null,
        public ?\DateTimeImmutable $createdAt = null,
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
            subject: Cast::string($data['subject'] ?? null),
            message: Cast::string($data['message'] ?? null),
            cc: Cast::strings($data['cc'] ?? null),
            tags: Cast::strings($data['tags'] ?? null),
            createdBy: Cast::string($data['createdBy'] ?? null),
            createdAt: Cast::dateTime($data['createdAt'] ?? null),
            raw: $data,
        );
    }
}
