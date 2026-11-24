<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Testing;

/**
 * Réponse simulée, dans le vocabulaire du SDK : le consommateur ne touche
 * jamais `Saloon\Http\Faking\MockResponse`.
 */
final readonly class MockedResponse
{
    /**
     * @param array<array-key, mixed>|string $body JSON à encoder, ou corps brut
     */
    public function __construct(
        public int $status,
        public array|string $body,
    ) {
    }
}
