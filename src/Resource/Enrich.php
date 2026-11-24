<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\EnrichDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Enrich\BulkEnrichData;
use Noneo\Sdk\Lemlist\Requests\Enrich\EnrichData;
use Noneo\Sdk\Lemlist\Requests\Enrich\EnrichLead;
use Noneo\Sdk\Lemlist\Requests\Enrich\GetEnrichmentResult;

/**
 * Section « Enrich » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Enrich
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Get Enrichment Result.
     *
     * `GET /enrich/{enrichId}`
     *
     * @param string $enrichId Enrichment ID returned when the enrichment was started
     */
    public function getEnrichmentResult(string $enrichId): EnrichDto
    {
        $response = $this->connector->send(new GetEnrichmentResult(enrichId: $enrichId));

        return EnrichDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Enrich Data.
     *
     * `POST /enrich`
     *
     * @param bool|null   $findEmail          Find the person's email
     * @param bool|null   $verifyEmail        Verify the deliverability of `email`
     * @param bool|null   $linkedinEnrichment Enrich the person's LinkedIn profile
     * @param string|null $email              Email address of the person
     * @param string|null $linkedinUrl        LinkedIn profile URL of the person
     * @param string|null $firstName          First name of the person
     * @param string|null $lastName           Last name of the person
     * @param string|null $companyDomain      Domain of the person's company
     * @param string|null $companyName        Name of the person's company
     * @param string|null $jobTitle           Job title of the person
     * @param bool|null   $findPhone          Find the person's phone number
     * @param string|null $webhookUrl         URL that receives the `enrichmentDone` or `enrichmentError` event of this enrichment, on top of your team's webhooks
     *
     * @return array<array-key, mixed>
     */
    public function enrichData(
        ?bool $findEmail = null,
        ?bool $verifyEmail = null,
        ?bool $linkedinEnrichment = null,
        ?string $email = null,
        ?string $linkedinUrl = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $companyDomain = null,
        ?string $companyName = null,
        ?string $jobTitle = null,
        ?bool $findPhone = null,
        ?string $webhookUrl = null,
    ): array {
        $response = $this->connector->send(new EnrichData(
            findEmail: $findEmail,
            verifyEmail: $verifyEmail,
            linkedinEnrichment: $linkedinEnrichment,
            email: $email,
            linkedinUrl: $linkedinUrl,
            firstName: $firstName,
            lastName: $lastName,
            companyDomain: $companyDomain,
            companyName: $companyName,
            jobTitle: $jobTitle,
            findPhone: $findPhone,
            webhookUrl: $webhookUrl,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Bulk Enrich Data.
     *
     * `POST /v2/enrichments/bulk`
     *
     * @param list<array<string, mixed>> $items
     * @param string|null                $webhookUrl URL that receives the `enrichmentDone` or `enrichmentError` event of each enrichment of the call, on top of your team's webhooks
     *
     * @return array<array-key, mixed>
     */
    public function bulkEnrichData(array $items, ?string $webhookUrl = null): array
    {
        $response = $this->connector->send(new BulkEnrichData(items: $items, webhookUrl: $webhookUrl));

        return ResponseDecoder::object($response);
    }

    /**
     * Enrich Lead.
     *
     * `POST /leads/{leadId}/enrich`
     *
     * @param string      $leadId             Unique lead ID
     * @param bool|null   $findEmail          Find the lead's email
     * @param bool|null   $verifyEmail        Verify the deliverability of the lead's email
     * @param bool|null   $linkedinEnrichment Enrich the lead's LinkedIn profile
     * @param bool|null   $findPhone          Find the lead's phone number
     * @param string|null $webhookUrl         URL that receives the `enrichmentDone` or `enrichmentError` event of this enrichment, on top of your team's webhooks
     * @param bool|null   $force              Re-run an enrichment that would otherwise be skipped
     *
     * @return array<array-key, mixed>
     */
    public function enrichLead(
        string $leadId,
        ?bool $findEmail = null,
        ?bool $verifyEmail = null,
        ?bool $linkedinEnrichment = null,
        ?bool $findPhone = null,
        ?string $webhookUrl = null,
        ?bool $force = null,
    ): array {
        $response = $this->connector->send(new EnrichLead(
            leadId: $leadId,
            findEmail: $findEmail,
            verifyEmail: $verifyEmail,
            linkedinEnrichment: $linkedinEnrichment,
            findPhone: $findPhone,
            webhookUrl: $webhookUrl,
            force: $force,
        ));

        return ResponseDecoder::object($response);
    }
}
