<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\SelfRecovery\GetSelfRecoveryConfig;
use Noneo\Sdk\Lemlist\Requests\SelfRecovery\ListSelfRecoveryHistory;
use Noneo\Sdk\Lemlist\Requests\SelfRecovery\UpdateSelfRecoveryConfig;

/**
 * Section « SelfRecovery » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class SelfRecovery
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Get Self-recovery Config.
     *
     * `GET /self-recovery/config`
     *
     * @return array<array-key, mixed>
     */
    public function getSelfRecoveryConfig(): array
    {
        $response = $this->connector->send(new GetSelfRecoveryConfig());

        return ResponseDecoder::object($response);
    }

    /**
     * Update Self-recovery Config.
     *
     * `PATCH /self-recovery/config`
     *
     * @param bool|null         $enabled           Turn self-recovery on or off
     * @param list<string>|null $monitoredSignals  Replaces the monitored-signals list
     * @param list<string>|null $authorizedActions Replaces the authorized-actions list
     * @param string|null       $digestFrequency   How often team admins get the recovery summary email: daily, or weekly on Mondays (valeurs : daily, weekly)
     *
     * @return array<array-key, mixed>
     */
    public function updateSelfRecoveryConfig(
        ?bool $enabled = null,
        ?array $monitoredSignals = null,
        ?array $authorizedActions = null,
        ?string $digestFrequency = null,
    ): array {
        $response = $this->connector->send(new UpdateSelfRecoveryConfig(
            enabled: $enabled,
            monitoredSignals: $monitoredSignals,
            authorizedActions: $authorizedActions,
            digestFrequency: $digestFrequency,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * List Self-recovery History.
     *
     * `GET /self-recovery/history`
     *
     * @param int|null $limit Max cases to return (1-100)
     * @param int|null $skip  Number of cases to skip, for pagination
     *
     * @return array<array-key, mixed>
     */
    public function listSelfRecoveryHistory(?int $limit = null, ?int $skip = null): array
    {
        $response = $this->connector->send(new ListSelfRecoveryHistory(limit: $limit, skip: $skip));

        return ResponseDecoder::object($response);
    }
}
