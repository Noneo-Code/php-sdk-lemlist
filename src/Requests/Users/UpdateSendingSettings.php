<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Users;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update Sending Settings — `PATCH /user/sending-settings`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateSendingSettings extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param list<array<string, mixed>> $emailAccounts
     */
    public function __construct(private readonly array $emailAccounts)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/user/sending-settings';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'emailAccounts' => $this->emailAccounts,
        ]);
    }
}
