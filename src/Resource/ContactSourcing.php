<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\ContactSourcingRunDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\ContactSourcing\AddASourcedContact;
use Noneo\Sdk\Lemlist\Requests\ContactSourcing\GetContactSourcingRun;
use Noneo\Sdk\Lemlist\Requests\ContactSourcing\RunContactSourcing;

/**
 * Section « ContactSourcing » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class ContactSourcing
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Get Contact Sourcing Run.
     *
     * `GET /contact-sourcing`
     *
     * @param string|null $runId     The run to read, as returned by `POST /contact-sourcing`
     * @param string|null $companyId Read the LATEST run of this account instead (`cpn_xxx` format)
     */
    public function getContactSourcingRun(?string $runId = null, ?string $companyId = null): ContactSourcingRunDto
    {
        $response = $this->connector->send(new GetContactSourcingRun(runId: $runId, companyId: $companyId));

        return ContactSourcingRunDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Run Contact Sourcing.
     *
     * `POST /contact-sourcing`
     *
     * @param list<string> $companyIds Accounts to source contacts for (`cpn_xxx` format)
     *
     * @return array<array-key, mixed>
     */
    public function runContactSourcing(array $companyIds, ?bool $overwrite = null): array
    {
        $response = $this->connector->send(new RunContactSourcing(companyIds: $companyIds, overwrite: $overwrite));

        return ResponseDecoder::object($response);
    }

    /**
     * Add a Sourced Contact.
     *
     * `POST /contact-sourcing/contacts`
     *
     * @param string      $leadId    People-Database id, from a run's `contacts[].leadId`
     * @param string|null $listId    File the new contact into this contact list (`clt_xxx`)
     * @param bool|null   $findEmail Also run email enrichment on the new contact
     */
    public function addASourcedContact(
        string $leadId,
        string $companyId,
        ?string $listId = null,
        ?bool $findEmail = null,
    ): mixed {
        $response = $this->connector->send(new AddASourcedContact(
            leadId: $leadId,
            companyId: $companyId,
            listId: $listId,
            findEmail: $findEmail,
        ));

        return ResponseDecoder::value($response);
    }
}
