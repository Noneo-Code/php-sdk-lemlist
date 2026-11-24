<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\SelfRecovery;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List Self-recovery History — `GET /self-recovery/history`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ListSelfRecoveryHistory extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?int $limit = null,
        private readonly ?int $skip = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/self-recovery/history';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'limit' => $this->limit,
            'skip' => $this->skip,
        ]);
    }
}
