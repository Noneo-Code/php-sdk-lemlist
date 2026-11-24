<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\WebhookDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Webhooks\AddWebhook;
use Noneo\Sdk\Lemlist\Requests\Webhooks\DeleteWebhook;
use Noneo\Sdk\Lemlist\Requests\Webhooks\GetManyWebhooks;

/**
 * Section « Webhooks » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Webhooks
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Get Many Webhooks.
     *
     * `GET /hooks`
     *
     * @return list<WebhookDto>
     */
    public function getManyWebhooks(): array
    {
        $response = $this->connector->send(new GetManyWebhooks());

        return array_map(WebhookDto::fromArray(...), ResponseDecoder::items($response));
    }

    /**
     * Add Webhook.
     *
     * `POST /hooks`
     *
     * @param string      $targetUrl  The URL that will receive webhook POST requests
     * @param string|null $type       Optional event type to subscribe to
     * @param string|null $secret     Optional shared secret
     * @param string|null $campaignId Webhook for specific campaign
     * @param bool|null   $isFirst    Webhook for first activity only
     * @param string|null $zapId      Zapier ID
     *
     * @return array<array-key, mixed>
     */
    public function addWebhook(
        string $targetUrl,
        ?string $type = null,
        #[\SensitiveParameter] ?string $secret = null,
        ?string $campaignId = null,
        ?bool $isFirst = null,
        ?string $zapId = null,
    ): array {
        $response = $this->connector->send(new AddWebhook(
            targetUrl: $targetUrl,
            type: $type,
            secret: $secret,
            campaignId: $campaignId,
            isFirst: $isFirst,
            zapId: $zapId,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Delete Webhook.
     *
     * `DELETE /hooks/{hookId}`
     *
     * @param string $hookId Unique webhook ID
     *
     * @return array<array-key, mixed>
     */
    public function deleteWebhook(string $hookId): array
    {
        $response = $this->connector->send(new DeleteWebhook(hookId: $hookId));

        return ResponseDecoder::object($response);
    }
}
