<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Users;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Sending Settings — `GET /user/sending-settings`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetSendingSettings extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly ?string $scope = null)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/user/sending-settings';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'scope' => $this->scope,
        ]);
    }
}
