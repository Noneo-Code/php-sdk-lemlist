<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Testing;

/**
 * Requête que le code sous test a envoyée au double.
 */
final readonly class RecordedRequest
{
    /**
     * @param string                       $path  chemin relatif à la base de l'API, comme dans la documentation lemlist
     * @param array<array-key, mixed>      $query
     * @param array<array-key, mixed>|null $body  corps JSON, ou `null` s'il n'y en a pas (ou s'il est multipart)
     */
    public function __construct(
        public string $method,
        public string $path,
        public array $query,
        public ?array $body,
    ) {
    }
}
