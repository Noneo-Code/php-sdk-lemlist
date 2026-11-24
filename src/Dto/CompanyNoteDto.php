<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `CompanyNote` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class CompanyNoteDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?string $teamId = null,
        public ?string $companyId = null,
        public ?string $note = null,
        public ?string $type = null,
        public ?string $userId = null,
        public ?string $sendUserId = null,
        public ?\DateTimeImmutable $createdAt = null,
        public ?\DateTimeImmutable $updatedAt = null,
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
            teamId: Cast::string($data['teamId'] ?? null),
            companyId: Cast::string($data['companyId'] ?? null),
            note: Cast::string($data['note'] ?? null),
            type: Cast::string($data['type'] ?? null),
            userId: Cast::string($data['userId'] ?? null),
            sendUserId: Cast::string($data['sendUserId'] ?? null),
            createdAt: Cast::dateTime($data['createdAt'] ?? null),
            updatedAt: Cast::dateTime($data['updatedAt'] ?? null),
            raw: $data,
        );
    }
}
