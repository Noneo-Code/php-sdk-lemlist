<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\SelfRecovery;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update Self-recovery Config — `PATCH /self-recovery/config`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateSelfRecoveryConfig extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param list<string>|null $monitoredSignals
     * @param list<string>|null $authorizedActions
     */
    public function __construct(
        private readonly ?bool $enabled = null,
        private readonly ?array $monitoredSignals = null,
        private readonly ?array $authorizedActions = null,
        private readonly ?string $digestFrequency = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/self-recovery/config';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'enabled' => $this->enabled,
            'monitoredSignals' => $this->monitoredSignals,
            'authorizedActions' => $this->authorizedActions,
            'digestFrequency' => $this->digestFrequency,
        ]);
    }
}
