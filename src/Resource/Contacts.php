<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\ContactDto;
use Noneo\Sdk\Lemlist\Dto\ContactNoteDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Contacts\AddAndUpdateContact;
use Noneo\Sdk\Lemlist\Requests\Contacts\AddOrRemoveContactsInAList;
use Noneo\Sdk\Lemlist\Requests\Contacts\CreateContactList;
use Noneo\Sdk\Lemlist\Requests\Contacts\CreateContactNote;
use Noneo\Sdk\Lemlist\Requests\Contacts\CreateContactsInTheCrm;
use Noneo\Sdk\Lemlist\Requests\Contacts\DeleteContact;
use Noneo\Sdk\Lemlist\Requests\Contacts\ExportContactList;
use Noneo\Sdk\Lemlist\Requests\Contacts\GetContact;
use Noneo\Sdk\Lemlist\Requests\Contacts\GetContactLists;
use Noneo\Sdk\Lemlist\Requests\Contacts\GetContactNotes;
use Noneo\Sdk\Lemlist\Requests\Contacts\GetManyContacts;
use Noneo\Sdk\Lemlist\Requests\Contacts\MergeContacts;
use Noneo\Sdk\Lemlist\Requests\Contacts\SearchConnectContactsInTheCrm;

/**
 * Section « Contacts » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Contacts
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Get Many Contacts.
     *
     * `GET /contacts`
     *
     * @param string|null $idsOrEmails          A comma separated string of either valid contact IDs (MongoDB ObjectId) or valid email addresses
     * @param string|null $crmIds               Comma-separated record ids of contacts in the CRM connected to the team (HubSpot, Salesforce, or Pipedrive); for Salesforce, the 18-character Contact or Lead id
     * @param string|null $search               Search contacts by name or other text fields
     * @param string|null $email                Search contacts by exact email address
     * @param string|null $listId               Filter contacts by contact list ID (`clt_xxx` format)
     * @param bool|null   $notInAnyCampaign     When set to `true`, only returns contacts that are not part of any campaign (orphan contacts)
     * @param string|null $companyId            Filter contacts by attached company ID (`cpn_xxx` format)
     * @param string|null $companyDomain        Filter contacts by their company's website domain
     * @param string|null $companyLinkedinUrl   Filter contacts by their company's LinkedIn URL
     * @param string|null $companySalesnavUrl   Filter contacts by their company's LinkedIn Sales Navigator URL
     * @param bool|null   $withPrimaryCompany   When set to `true`, only returns contacts linked to a company; when set to `false`, only returns contacts without a company
     * @param string|null $fieldRejectionReason Filter contacts to those carrying a field rejection with this reason — a value lemlist refused to write, prefixed by its origin (`enrichment_*` while enriching…
     * @param string|null $crmSyncStatus        Filter contacts by their CRM sync state against the team's active CRM provider
     * @param int|null    $limit                Maximum number of contacts to return (1–500)
     * @param int|null    $offset               Number of contacts to skip for pagination
     *
     * @return array<array-key, mixed>
     */
    public function getManyContacts(
        ?string $idsOrEmails = null,
        ?string $crmIds = null,
        ?string $search = null,
        ?string $email = null,
        ?string $listId = null,
        ?bool $notInAnyCampaign = null,
        ?string $companyId = null,
        ?string $companyDomain = null,
        ?string $companyLinkedinUrl = null,
        ?string $companySalesnavUrl = null,
        ?bool $withPrimaryCompany = null,
        ?string $fieldRejectionReason = null,
        ?string $crmSyncStatus = null,
        ?int $limit = null,
        ?int $offset = null,
    ): array {
        $response = $this->connector->send(new GetManyContacts(
            idsOrEmails: $idsOrEmails,
            crmIds: $crmIds,
            search: $search,
            email: $email,
            listId: $listId,
            notInAnyCampaign: $notInAnyCampaign,
            companyId: $companyId,
            companyDomain: $companyDomain,
            companyLinkedinUrl: $companyLinkedinUrl,
            companySalesnavUrl: $companySalesnavUrl,
            withPrimaryCompany: $withPrimaryCompany,
            fieldRejectionReason: $fieldRejectionReason,
            crmSyncStatus: $crmSyncStatus,
            limit: $limit,
            offset: $offset,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Add and update contact.
     *
     * `POST /contacts`
     *
     * @param string|null          $contactId               Existing contact ID
     * @param string|null          $email                   Contact email address
     * @param string|null          $linkedinUrl             LinkedIn profile URL
     * @param string|null          $linkedinUrlSalesNav     LinkedIn Sales Navigator profile URL
     * @param list<string>|null    $additionalEmails        Additional email addresses for the contact
     * @param string|null          $firstName               Contact first name
     * @param string|null          $lastName                Contact last name
     * @param string|null          $phone                   Contact phone number
     * @param string|null          $jobTitle                Contact job title
     * @param string|null          $jobDescription          Contact job description
     * @param string|null          $picture                 URL of the contact's profile picture
     * @param string|null          $timezone                Contact timezone
     * @param string|null          $industry                Contact industry
     * @param string|null          $languages               Contact languages
     * @param string|null          $location                Contact location
     * @param string|null          $skills                  Contact skills
     * @param string|null          $summary                 Contact summary or bio
     * @param string|null          $tagline                 Contact tagline
     * @param string|null          $peopleDbSeniority       Seniority of the person, from the People Database
     * @param string|null          $peopleDbDepartment      Department of the person, from the People Database
     * @param string|null          $peopleDbConnectionCount LinkedIn connections count of the person, from the People Database
     * @param string|null          $contactOwner            Owner of the contact
     * @param string|null          $source                  Origin of the contact record
     * @param string|null          $companyId               ID of a company already existing in lemlist to link to this contact
     * @param string|null          $companyDomain           Domain of a company already existing in lemlist to link to this contact (e.g
     * @param string|null          $companyLinkedinUrl      LinkedIn URL of a company already existing in lemlist to link to this contact
     * @param string|null          $crmId                   Reserved for this link, never written to a custom field
     * @param string|null          $updateStrategy          What an existing record keeps (valeurs : overwrite, overwriteIgnoreEmpty, fillEmptyOnly)
     * @param array<string, mixed> $additional              champs supplémentaires, envoyés tels quels (variables personnalisées…)
     *
     * @return array<array-key, mixed>
     */
    public function addAndUpdateContact(
        ?string $contactId = null,
        ?string $email = null,
        ?string $linkedinUrl = null,
        ?string $linkedinUrlSalesNav = null,
        ?array $additionalEmails = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $phone = null,
        ?string $jobTitle = null,
        ?string $jobDescription = null,
        ?string $picture = null,
        ?string $timezone = null,
        ?string $industry = null,
        ?string $languages = null,
        ?string $location = null,
        ?string $skills = null,
        ?string $summary = null,
        ?string $tagline = null,
        ?string $peopleDbSeniority = null,
        ?string $peopleDbDepartment = null,
        ?string $peopleDbConnectionCount = null,
        ?string $contactOwner = null,
        ?string $source = null,
        ?string $companyId = null,
        ?string $companyDomain = null,
        ?string $companyLinkedinUrl = null,
        ?string $crmId = null,
        ?string $updateStrategy = null,
        array $additional = [],
    ): array {
        $response = $this->connector->send(new AddAndUpdateContact(
            contactId: $contactId,
            email: $email,
            linkedinUrl: $linkedinUrl,
            linkedinUrlSalesNav: $linkedinUrlSalesNav,
            additionalEmails: $additionalEmails,
            firstName: $firstName,
            lastName: $lastName,
            phone: $phone,
            jobTitle: $jobTitle,
            jobDescription: $jobDescription,
            picture: $picture,
            timezone: $timezone,
            industry: $industry,
            languages: $languages,
            location: $location,
            skills: $skills,
            summary: $summary,
            tagline: $tagline,
            peopleDbSeniority: $peopleDbSeniority,
            peopleDbDepartment: $peopleDbDepartment,
            peopleDbConnectionCount: $peopleDbConnectionCount,
            contactOwner: $contactOwner,
            source: $source,
            companyId: $companyId,
            companyDomain: $companyDomain,
            companyLinkedinUrl: $companyLinkedinUrl,
            crmId: $crmId,
            updateStrategy: $updateStrategy,
            additional: $additional,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Merge Contacts.
     *
     * `POST /contacts/merge`
     *
     * @param string       $primaryId    The surviving contact
     * @param list<string> $secondaryIds The contacts folded into the survivor then deleted, 9 at most
     *
     * @return array<array-key, mixed>
     */
    public function mergeContacts(string $primaryId, array $secondaryIds): array
    {
        $response = $this->connector->send(new MergeContacts(primaryId: $primaryId, secondaryIds: $secondaryIds));

        return ResponseDecoder::object($response);
    }

    /**
     * Search & Connect Contacts in the CRM.
     *
     * `POST /contacts/crm/search-and-connect`
     *
     * @param list<string>|null $idsOrEmails lemlist contact ids (`ctc_xxx`) or email addresses, 10,000 at most
     * @param string|null       $listId      A contact list id (`clt_xxx`): acts on every contact of the list, static or dynamic, 10,000 at most
     *
     * @return array<array-key, mixed>
     */
    public function searchConnectContactsInTheCrm(?array $idsOrEmails = null, ?string $listId = null): array
    {
        $response = $this->connector->send(new SearchConnectContactsInTheCrm(idsOrEmails: $idsOrEmails, listId: $listId));

        return ResponseDecoder::object($response);
    }

    /**
     * Create Contacts in the CRM.
     *
     * `POST /contacts/crm/create`
     *
     * @param list<string>|null $idsOrEmails lemlist contact ids (`ctc_xxx`) or email addresses, 10,000 at most
     * @param string|null       $listId      A contact list id (`clt_xxx`): acts on every contact of the list, static or dynamic, 10,000 at most
     * @param bool|null         $asLead      Salesforce only: create the contacts missing from the CRM as Leads instead of Contacts
     *
     * @return array<array-key, mixed>
     */
    public function createContactsInTheCrm(
        ?array $idsOrEmails = null,
        ?string $listId = null,
        ?bool $asLead = null,
    ): array {
        $response = $this->connector->send(new CreateContactsInTheCrm(
            idsOrEmails: $idsOrEmails,
            listId: $listId,
            asLead: $asLead,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Contact.
     *
     * `GET /contacts/{idOrEmail}`
     *
     * @param string $idOrEmail The unique identifier or email of the contact
     */
    public function getContact(string $idOrEmail): ContactDto
    {
        $response = $this->connector->send(new GetContact(idOrEmail: $idOrEmail));

        return ContactDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Delete Contact.
     *
     * `DELETE /contacts/{idOrEmail}`
     *
     * @param string $idOrEmail The unique identifier or email of the contact
     *
     * @return array<array-key, mixed>
     */
    public function deleteContact(string $idOrEmail): array
    {
        $response = $this->connector->send(new DeleteContact(idOrEmail: $idOrEmail));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Contact Notes.
     *
     * `GET /contacts/{idOrEmail}/notes`
     *
     * @param string      $idOrEmail The unique identifier (`ctc_xxx`) or email of the contact
     * @param int|null    $limit     Number of notes per page
     * @param int|null    $page      Page number to retrieve, starting at 1
     * @param string|null $sortBy    The field to sort by (valeurs : createdAt)
     * @param string|null $sortOrder The sort direction (valeurs : asc, desc)
     *
     * @return array<array-key, mixed>
     */
    public function getContactNotes(
        string $idOrEmail,
        ?int $limit = null,
        ?int $page = null,
        ?string $sortBy = null,
        ?string $sortOrder = null,
    ): array {
        $response = $this->connector->send(new GetContactNotes(
            idOrEmail: $idOrEmail,
            limit: $limit,
            page: $page,
            sortBy: $sortBy,
            sortOrder: $sortOrder,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Create Contact Note.
     *
     * `POST /contacts/{idOrEmail}/notes`
     *
     * @param string      $idOrEmail The unique identifier (`ctc_xxx`) or email of the contact
     * @param string|null $note      The note content
     */
    public function createContactNote(string $idOrEmail, ?string $note = null): ContactNoteDto
    {
        $response = $this->connector->send(new CreateContactNote(idOrEmail: $idOrEmail, note: $note));

        return ContactNoteDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Get Contact Lists.
     *
     * `GET /contacts/lists`
     *
     * @param string|null $search Filter lists by name (case-insensitive partial match)
     *
     * @return array<array-key, mixed>
     */
    public function getContactLists(?string $search = null): array
    {
        $response = $this->connector->send(new GetContactLists(search: $search));

        return ResponseDecoder::object($response);
    }

    /**
     * Create Contact List.
     *
     * `POST /contacts/lists`
     *
     * @param string $name Name of the contact list to create (max 200 characters)
     *
     * @return array<array-key, mixed>
     */
    public function createContactList(string $name): array
    {
        $response = $this->connector->send(new CreateContactList(name: $name));

        return ResponseDecoder::object($response);
    }

    /**
     * Add or Remove Contacts in a List.
     *
     * `POST /contacts/lists/{listId}/entities`
     *
     * @param string       $listId     The unique identifier of the contact list (`clt_xxx` format)
     * @param list<string> $contactIds Array of contact IDs (`ctc_xxx` format) to add to or remove from the list
     * @param string|null  $action     Omit to **add** the contacts to the list (valeurs : remove)
     *
     * @return array<array-key, mixed>
     */
    public function addOrRemoveContactsInAList(
        string $listId,
        array $contactIds,
        ?string $action = null,
    ): array {
        $response = $this->connector->send(new AddOrRemoveContactsInAList(
            listId: $listId,
            contactIds: $contactIds,
            action: $action,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Export Contact List.
     *
     * `GET /contacts/export`
     *
     * @param string      $listId The contact list ID to export (`clt_xxx` format), or `"all"` to export all contacts
     * @param string|null $entity The type of entities to export (valeurs : contact, company)
     */
    public function exportContactList(string $listId, ?string $entity = null): string
    {
        $response = $this->connector->send(new ExportContactList(listId: $listId, entity: $entity));

        return ResponseDecoder::text($response);
    }
}
