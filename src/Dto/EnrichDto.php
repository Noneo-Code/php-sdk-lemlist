<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Dto;

use Noneo\Sdk\Lemlist\Support\Cast;

/**
 * Schéma `Enrich` de la spec lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final readonly class EnrichDto
{
    /**
     * @param array<array-key, mixed>|null $input
     * @param list<string>|null            $failedWorkflows
     * @param array<array-key, mixed>      $raw             corps d'origine, champs non documentés compris
     */
    public function __construct(
        public ?string $enrichmentId = null,
        public ?string $enrichmentStatus = null,
        public ?array $input = null,
        public ?EnrichDataDto $data = null,
        public ?array $failedWorkflows = null,
        public ?string $code = null,
        public ?string $reason = null,
        public ?string $error = null,
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
            enrichmentId: Cast::string($data['enrichmentId'] ?? null),
            enrichmentStatus: Cast::string($data['enrichmentStatus'] ?? null),
            input: Cast::map($data['input'] ?? null),
            data: Cast::object($data['data'] ?? null, EnrichDataDto::fromArray(...)),
            failedWorkflows: Cast::strings($data['failedWorkflows'] ?? null),
            code: Cast::string($data['code'] ?? null),
            reason: Cast::string($data['reason'] ?? null),
            error: Cast::string($data['error'] ?? null),
            raw: $data,
        );
    }
}
