<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\LemwarmSettingsDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Warmup\GetWarmupErrors;
use Noneo\Sdk\Lemlist\Requests\Warmup\GetWarmupSettings;
use Noneo\Sdk\Lemlist\Requests\Warmup\PauseWarmup;
use Noneo\Sdk\Lemlist\Requests\Warmup\StartWarmup;
use Noneo\Sdk\Lemlist\Requests\Warmup\UpdateWarmupSettings;

/**
 * Section « Warmup » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Warmup
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Get warmup errors.
     *
     * `GET /warmup/errors`
     *
     * @return array<array-key, mixed>
     */
    public function getWarmupErrors(): array
    {
        $response = $this->connector->send(new GetWarmupErrors());

        return ResponseDecoder::object($response);
    }

    /**
     * Start warmup.
     *
     * `POST /warmup/{userMailboxId}/start`
     *
     * @param string $userMailboxId The unique identifier of the user mailbox
     *
     * @return array<array-key, mixed>
     */
    public function startWarmup(string $userMailboxId): array
    {
        $response = $this->connector->send(new StartWarmup(userMailboxId: $userMailboxId));

        return ResponseDecoder::object($response);
    }

    /**
     * Pause warmup.
     *
     * `POST /warmup/{userMailboxId}/pause`
     *
     * @param string $userMailboxId The unique identifier of the user mailbox
     *
     * @return array<array-key, mixed>
     */
    public function pauseWarmup(string $userMailboxId): array
    {
        $response = $this->connector->send(new PauseWarmup(userMailboxId: $userMailboxId));

        return ResponseDecoder::object($response);
    }

    /**
     * Get warmup settings.
     *
     * `GET /warmup/{userMailboxId}/settings`
     *
     * @param string $userMailboxId The unique identifier of the user mailbox
     */
    public function getWarmupSettings(string $userMailboxId): LemwarmSettingsDto
    {
        $response = $this->connector->send(new GetWarmupSettings(userMailboxId: $userMailboxId));

        return LemwarmSettingsDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Update warmup settings.
     *
     * `PATCH /warmup/{userMailboxId}/settings`
     *
     * @param string    $userMailboxId                The unique identifier of the user mailbox
     * @param int|null  $warmEmailMax                 Maximum number of warmup emails per day (0-40; the server enforces 1-40 unless the team has the lemwarm0limit beta)
     * @param int|null  $warmEmailRampup              Daily increase in the warmup email count (0-40; the server enforces 1-40 unless the team has the lemwarm0limit beta)
     * @param int|null  $internalCommunicationPercent Percentage of warmup emails sent to internal participants (0-100)
     * @param int|null  $answerPercentage             Percentage of warmup emails that should be answered (0-100)
     * @param bool|null $warmUsePlaintext             Whether warmup emails are sent as plain text
     * @param bool|null $warmDailyVarianceEnabled     Whether to apply a random daily variance to the warmup email target (spreads volume day-to-day instead of a flat number)
     *
     * @return array<array-key, mixed>
     */
    public function updateWarmupSettings(
        string $userMailboxId,
        ?int $warmEmailMax = null,
        ?int $warmEmailRampup = null,
        ?int $internalCommunicationPercent = null,
        ?int $answerPercentage = null,
        ?bool $warmUsePlaintext = null,
        ?bool $warmDailyVarianceEnabled = null,
    ): array {
        $response = $this->connector->send(new UpdateWarmupSettings(
            userMailboxId: $userMailboxId,
            warmEmailMax: $warmEmailMax,
            warmEmailRampup: $warmEmailRampup,
            internalCommunicationPercent: $internalCommunicationPercent,
            answerPercentage: $answerPercentage,
            warmUsePlaintext: $warmUsePlaintext,
            warmDailyVarianceEnabled: $warmDailyVarianceEnabled,
        ));

        return ResponseDecoder::object($response);
    }
}
