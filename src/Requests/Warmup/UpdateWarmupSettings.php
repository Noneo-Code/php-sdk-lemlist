<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Warmup;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update warmup settings — `PATCH /warmup/{userMailboxId}/settings`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class UpdateWarmupSettings extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        private readonly string $userMailboxId,
        private readonly ?int $warmEmailMax = null,
        private readonly ?int $warmEmailRampup = null,
        private readonly ?int $internalCommunicationPercent = null,
        private readonly ?int $answerPercentage = null,
        private readonly ?bool $warmUsePlaintext = null,
        private readonly ?bool $warmDailyVarianceEnabled = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/warmup/'.rawurlencode($this->userMailboxId).'/settings';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'warmEmailMax' => $this->warmEmailMax,
            'warmEmailRampup' => $this->warmEmailRampup,
            'internalCommunicationPercent' => $this->internalCommunicationPercent,
            'answerPercentage' => $this->answerPercentage,
            'warmUsePlaintext' => $this->warmUsePlaintext,
            'warmDailyVarianceEnabled' => $this->warmDailyVarianceEnabled,
        ]);
    }
}
