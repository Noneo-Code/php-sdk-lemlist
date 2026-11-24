<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\DeliverabilityAlertDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\DeliverabilityAlerts\CreateDeliverabilityAlert;
use Noneo\Sdk\Lemlist\Requests\DeliverabilityAlerts\DeleteDeliverabilityAlert;
use Noneo\Sdk\Lemlist\Requests\DeliverabilityAlerts\GetDeliverabilityAlert;
use Noneo\Sdk\Lemlist\Requests\DeliverabilityAlerts\ListDeliverabilityAlerts;
use Noneo\Sdk\Lemlist\Requests\DeliverabilityAlerts\ListDeliverabilityIncidents;
use Noneo\Sdk\Lemlist\Requests\DeliverabilityAlerts\UpdateDeliverabilityAlert;

/**
 * Section « DeliverabilityAlerts » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class DeliverabilityAlerts
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * List Deliverability Alerts.
     *
     * `GET /deliverability/alerts`
     *
     * @return array<array-key, mixed>
     */
    public function listDeliverabilityAlerts(): array
    {
        $response = $this->connector->send(new ListDeliverabilityAlerts());

        return ResponseDecoder::object($response);
    }

    /**
     * Create Deliverability Alert.
     *
     * `POST /deliverability/alerts`
     *
     * @param string                    $widget             valeurs : warmup, outreach
     * @param string                    $metric             valeurs : inboxRate, spamRate, score, deliveryRate, bounceRate
     * @param string                    $severity           valeurs : warning, critical
     * @param string                    $scope              valeurs : global, mailbox, domain
     * @param string                    $comparisonOperator valeurs : equal, below, above
     * @param string                    $periodMode         valeurs : rolling, consecutive
     * @param list<string>|null         $scopeEntities      Required when `scope` is `mailbox` or `domain` and you want to target specific entities
     * @param array<string, mixed>|null $channelConfig      Notification channels triggered when the alert fires
     * @param int|null                  $recheckDelayHours  Cool-down between re-evaluations after the alert triggers, in hours
     */
    public function createDeliverabilityAlert(
        string $widget,
        string $metric,
        string $severity,
        string $scope,
        float $threshold,
        string $comparisonOperator,
        int $periodDays,
        string $periodMode,
        ?array $scopeEntities = null,
        ?array $channelConfig = null,
        ?int $recheckDelayHours = null,
    ): DeliverabilityAlertDto {
        $response = $this->connector->send(new CreateDeliverabilityAlert(
            widget: $widget,
            metric: $metric,
            severity: $severity,
            scope: $scope,
            threshold: $threshold,
            comparisonOperator: $comparisonOperator,
            periodDays: $periodDays,
            periodMode: $periodMode,
            scopeEntities: $scopeEntities,
            channelConfig: $channelConfig,
            recheckDelayHours: $recheckDelayHours,
        ));

        return DeliverabilityAlertDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Get Deliverability Alert.
     *
     * `GET /deliverability/alerts/{alertId}`
     *
     * @param string $alertId Unique alert configuration ID
     */
    public function getDeliverabilityAlert(string $alertId): DeliverabilityAlertDto
    {
        $response = $this->connector->send(new GetDeliverabilityAlert(alertId: $alertId));

        return DeliverabilityAlertDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Update Deliverability Alert.
     *
     * `PATCH /deliverability/alerts/{alertId}`
     *
     * @param string                    $alertId            Unique alert configuration ID
     * @param string|null               $comparisonOperator valeurs : equal, below, above
     * @param string|null               $periodMode         valeurs : rolling, consecutive
     * @param array<string, mixed>|null $channelConfig      Notification channels triggered when the alert fires
     * @param list<string>|null         $scopeEntities      Same format as on creation
     * @param bool|null                 $enabled            Pause or resume evaluation of this alert
     */
    public function updateDeliverabilityAlert(
        string $alertId,
        ?float $threshold = null,
        ?string $comparisonOperator = null,
        ?int $periodDays = null,
        ?string $periodMode = null,
        ?array $channelConfig = null,
        ?array $scopeEntities = null,
        ?bool $enabled = null,
    ): DeliverabilityAlertDto {
        $response = $this->connector->send(new UpdateDeliverabilityAlert(
            alertId: $alertId,
            threshold: $threshold,
            comparisonOperator: $comparisonOperator,
            periodDays: $periodDays,
            periodMode: $periodMode,
            channelConfig: $channelConfig,
            scopeEntities: $scopeEntities,
            enabled: $enabled,
        ));

        return DeliverabilityAlertDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Delete Deliverability Alert.
     *
     * `DELETE /deliverability/alerts/{alertId}`
     *
     * @param string $alertId Unique alert configuration ID
     *
     * @return array<array-key, mixed>
     */
    public function deleteDeliverabilityAlert(string $alertId): array
    {
        $response = $this->connector->send(new DeleteDeliverabilityAlert(alertId: $alertId));

        return ResponseDecoder::object($response);
    }

    /**
     * List Deliverability Incidents.
     *
     * `GET /deliverability/incidents`
     *
     * @param string|null $type   Only incidents of this type (valeurs : dnsIssue, mailboxDisconnected, lemwarmDisconnected, lemwarmPaused)
     * @param string|null $state  `active`: the issue is still there (valeurs : active, resolved)
     * @param string|null $userId Only incidents on mailboxes owned by this teammate
     * @param string|null $since  Only incidents detected at or after this date or instant (ISO 8601; a date-time needs its offset)
     * @param string|null $until  Only incidents detected at or before this date or instant (ISO 8601; a date-time needs its offset)
     * @param int|null    $limit  Maximum number of incidents to return
     * @param int|null    $skip   Number of incidents to skip, for pagination
     *
     * @return array<array-key, mixed>
     */
    public function listDeliverabilityIncidents(
        ?string $type = null,
        ?string $state = null,
        ?string $userId = null,
        ?string $since = null,
        ?string $until = null,
        ?int $limit = null,
        ?int $skip = null,
    ): array {
        $response = $this->connector->send(new ListDeliverabilityIncidents(
            type: $type,
            state: $state,
            userId: $userId,
            since: $since,
            until: $until,
            limit: $limit,
            skip: $skip,
        ));

        return ResponseDecoder::object($response);
    }
}
