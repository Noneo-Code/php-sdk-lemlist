<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\EnrichmentProviderListResponseDto;
use Noneo\Sdk\Lemlist\Dto\EnrichmentProviderResponseDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\EnrichmentProviders\ConnectEnrichmentProvider;
use Noneo\Sdk\Lemlist\Requests\EnrichmentProviders\DisconnectEnrichmentProvider;
use Noneo\Sdk\Lemlist\Requests\EnrichmentProviders\ListEnrichmentProviders;

/**
 * Section « EnrichmentProviders » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class EnrichmentProviders
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * List Enrichment Providers.
     *
     * `GET /v2/enrichments/providers`
     *
     * @param string $type Enrichment type of the providers to list (valeurs : email, phone)
     */
    public function listEnrichmentProviders(string $type): EnrichmentProviderListResponseDto
    {
        $response = $this->connector->send(new ListEnrichmentProviders(type: $type));

        return EnrichmentProviderListResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Connect Provider.
     *
     * `PUT /v2/enrichments/providers/{providerId}/connection`
     *
     * @param string $providerId Id of an external provider, as listed by `GET /enrichments/providers`
     * @param string $apiKey     API key issued by the provider to your account
     */
    public function connectEnrichmentProvider(string $providerId, #[\SensitiveParameter] string $apiKey): EnrichmentProviderResponseDto
    {
        $response = $this->connector->send(new ConnectEnrichmentProvider(providerId: $providerId, apiKey: $apiKey));

        return EnrichmentProviderResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Disconnect Provider.
     *
     * `DELETE /v2/enrichments/providers/{providerId}/connection`
     *
     * @param string $providerId Id of an external provider, as listed by `GET /enrichments/providers`
     */
    public function disconnectEnrichmentProvider(string $providerId): EnrichmentProviderResponseDto
    {
        $response = $this->connector->send(new DisconnectEnrichmentProvider(providerId: $providerId));

        return EnrichmentProviderResponseDto::fromArray(ResponseDecoder::object($response));
    }
}
