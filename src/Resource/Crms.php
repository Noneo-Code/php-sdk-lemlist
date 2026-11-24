<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Crms\GetCrmLogs;

/**
 * Section « Crms » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Crms
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Get CRM Logs.
     *
     * `GET /v2/crm/logs`
     *
     * @param string|null                    $contactId The contact whose history to read (`ctc_xxx`)
     * @param string|null                    $companyId The company whose history to read (`cpn_xxx`)
     * @param int|null                       $page      Page number, starting at 1
     * @param int|null                       $limit     Number of logs per page, from 1 to 100
     * @param string|null                    $state     Only the logs in these states, comma-separated: `pending`, `done`, `error`, `aborted`
     * @param string|null                    $category  Only the logs of these categories, comma-separated: `contact`, `company`, `association`, `activity`, `email`, `linkedin`, `sms`, `whatsapp`, `call`, `note`, `t…
     * @param string|null                    $method    Only the logs of these operations, comma-separated, by their `method` name (see `CrmLog.method`)
     * @param string|null                    $field     Only the logs that wrote or skipped one of these fields, comma-separated: at most 10 names of 100 characters each (`INVALID_PARAMETER`)
     * @param \DateTimeInterface|string|null $from      Only the logs created at or after this date (ISO 8601, read in UTC: a time without offset is UTC, a date without time starts at 00:00)
     * @param \DateTimeInterface|string|null $to        Only the logs created at or before this date (ISO 8601, read in UTC: a time without offset is UTC, a date without time covers that whole day, up to 23:59:59.99…
     *
     * @return array<array-key, mixed>
     */
    public function getCrmLogs(
        ?string $contactId = null,
        ?string $companyId = null,
        ?int $page = null,
        ?int $limit = null,
        ?string $state = null,
        ?string $category = null,
        ?string $method = null,
        ?string $field = null,
        \DateTimeInterface|string|null $from = null,
        \DateTimeInterface|string|null $to = null,
    ): array {
        $response = $this->connector->send(new GetCrmLogs(
            contactId: $contactId,
            companyId: $companyId,
            page: $page,
            limit: $limit,
            state: $state,
            category: $category,
            methodValue: $method,
            field: $field,
            from: $from,
            to: $to,
        ));

        return ResponseDecoder::object($response);
    }
}
