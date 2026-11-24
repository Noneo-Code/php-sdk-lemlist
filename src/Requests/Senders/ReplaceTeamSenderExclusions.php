<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Senders;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Replace Team Sender Exclusions — `PUT /team/dynamic-sender-exclusions`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ReplaceTeamSenderExclusions extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    /**
     * @param list<array<string, mixed>> $senders
     */
    public function __construct(private readonly array $senders)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/team/dynamic-sender-exclusions';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'senders' => $this->senders,
        ]);
    }
}
