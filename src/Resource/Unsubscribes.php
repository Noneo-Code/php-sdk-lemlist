<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\ContactSubscriptionStatusDto;
use Noneo\Sdk\Lemlist\Dto\UnsubscribedVariableDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Unsubscribes\BulkUnsubscribeVariables;
use Noneo\Sdk\Lemlist\Requests\Unsubscribes\ExportUnsubscribedContacts;
use Noneo\Sdk\Lemlist\Requests\Unsubscribes\ExportUnsubscribedVariables;
use Noneo\Sdk\Lemlist\Requests\Unsubscribes\GetContactSubscriptionStatus;
use Noneo\Sdk\Lemlist\Requests\Unsubscribes\GetUnsubscribedVariable;
use Noneo\Sdk\Lemlist\Requests\Unsubscribes\ListUnsubscribedVariables;
use Noneo\Sdk\Lemlist\Requests\Unsubscribes\ReSubscribeContact;
use Noneo\Sdk\Lemlist\Requests\Unsubscribes\ReSubscribeVariable;
use Noneo\Sdk\Lemlist\Requests\Unsubscribes\UnsubscribeContact;
use Noneo\Sdk\Lemlist\Requests\Unsubscribes\UnsubscribeVariable;

/**
 * Section « Unsubscribes » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Unsubscribes
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * List Unsubscribed Variables.
     *
     * `GET /v2/unsubscribes/variables`
     *
     * @param int|null $offset Number of entries to skip for pagination
     * @param int|null $limit  Number of entries to return (max 100)
     *
     * @return list<UnsubscribedVariableDto>
     */
    public function listUnsubscribedVariables(?int $offset = null, ?int $limit = null): array
    {
        $response = $this->connector->send(new ListUnsubscribedVariables(offset: $offset, limit: $limit));

        return array_map(UnsubscribedVariableDto::fromArray(...), ResponseDecoder::items($response));
    }

    /**
     * Bulk Unsubscribe Variables.
     *
     * `POST /v2/unsubscribes/variables`
     *
     * @param list<string> $values List of variables to unsubscribe (emails, domains, LinkedIn URLs, or phone numbers)
     */
    public function bulkUnsubscribeVariables(array $values): mixed
    {
        $response = $this->connector->send(new BulkUnsubscribeVariables(values: $values));

        return ResponseDecoder::value($response);
    }

    /**
     * Get Unsubscribed Variable.
     *
     * `GET /v2/unsubscribes/variables/{value}`
     *
     * @param string $value The variable value (email, domain, LinkedIn URL, or phone number)
     *
     * @return array<array-key, mixed>
     */
    public function getUnsubscribedVariable(string $value): array
    {
        $response = $this->connector->send(new GetUnsubscribedVariable(value: $value));

        return ResponseDecoder::object($response);
    }

    /**
     * Unsubscribe Variable.
     *
     * `POST /v2/unsubscribes/variables/{value}`
     *
     * @param string $value The variable value to unsubscribe (email, domain, LinkedIn URL, or phone number)
     *
     * @return array<array-key, mixed>
     */
    public function unsubscribeVariable(string $value): array
    {
        $response = $this->connector->send(new UnsubscribeVariable(value: $value));

        return ResponseDecoder::object($response);
    }

    /**
     * Re-subscribe Variable.
     *
     * `DELETE /v2/unsubscribes/variables/{value}`
     *
     * @param string $value The variable value to re-subscribe
     */
    public function reSubscribeVariable(string $value): mixed
    {
        $response = $this->connector->send(new ReSubscribeVariable(value: $value));

        return ResponseDecoder::value($response);
    }

    /**
     * Get Contact Subscription Status.
     *
     * `GET /v2/unsubscribes/contacts/{contactId}`
     *
     * @param string $contactId The contact identifier
     */
    public function getContactSubscriptionStatus(string $contactId): ContactSubscriptionStatusDto
    {
        $response = $this->connector->send(new GetContactSubscriptionStatus(contactId: $contactId));

        return ContactSubscriptionStatusDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Unsubscribe Contact.
     *
     * `POST /v2/unsubscribes/contacts/{contactId}`
     *
     * @param string $contactId The contact identifier
     */
    public function unsubscribeContact(string $contactId): mixed
    {
        $response = $this->connector->send(new UnsubscribeContact(contactId: $contactId));

        return ResponseDecoder::value($response);
    }

    /**
     * Re-subscribe Contact.
     *
     * `DELETE /v2/unsubscribes/contacts/{contactId}`
     *
     * @param string $contactId The contact identifier
     */
    public function reSubscribeContact(string $contactId): mixed
    {
        $response = $this->connector->send(new ReSubscribeContact(contactId: $contactId));

        return ResponseDecoder::value($response);
    }

    /**
     * Export Unsubscribed Variables.
     *
     * `GET /v2/unsubscribes/exports/variables`
     *
     * @param string|null $format Output format: 'json' or 'csv' (valeurs : csv, json)
     */
    public function exportUnsubscribedVariables(?string $format = null): mixed
    {
        $response = $this->connector->send(new ExportUnsubscribedVariables(format: $format));

        return ResponseDecoder::value($response);
    }

    /**
     * Export Unsubscribed Contacts.
     *
     * `GET /v2/unsubscribes/exports/contacts`
     *
     * @param string|null $format Output format: 'json' or 'csv' (valeurs : csv, json)
     */
    public function exportUnsubscribedContacts(?string $format = null): mixed
    {
        $response = $this->connector->send(new ExportUnsubscribedContacts(format: $format));

        return ResponseDecoder::value($response);
    }
}
