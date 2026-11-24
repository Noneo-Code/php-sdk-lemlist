<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `SignalSchema` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class SignalSchemaDto
{
    /**
     * @param array<array-key, mixed> $raw corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $_id = null,
        public ?string $teamId = null,
        public ?string $watchListId = null,
        public ?string $watchListName = null,
        public ?string $type = null,
        public ?string $status = null,
        public ?\DateTimeImmutable $receivedAt = null,
        public ?\DateTimeImmutable $createdAt = null,
        public ?SignalSchemaContactDto $contact = null,
        public ?SignalSchemaCompanyDto $company = null,
        public ?SignalSchemaSignalDataDto $signalData = null,
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
            watchListId: Cast::string($data['watchListId'] ?? null),
            watchListName: Cast::string($data['watchListName'] ?? null),
            type: Cast::string($data['type'] ?? null),
            status: Cast::string($data['status'] ?? null),
            receivedAt: Cast::dateTime($data['receivedAt'] ?? null),
            createdAt: Cast::dateTime($data['createdAt'] ?? null),
            contact: Cast::object($data['contact'] ?? null, SignalSchemaContactDto::fromArray(...)),
            company: Cast::object($data['company'] ?? null, SignalSchemaCompanyDto::fromArray(...)),
            signalData: Cast::object($data['signalData'] ?? null, SignalSchemaSignalDataDto::fromArray(...)),
            raw: $data,
        );
    }
}
