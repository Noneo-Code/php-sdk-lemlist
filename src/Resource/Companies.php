<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\CompanyDto;
use Noneo\Sdk\Lemlist\Dto\CompanyNoteDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Companies\AddAndUpdateCompany;
use Noneo\Sdk\Lemlist\Requests\Companies\AddOrRemoveCompaniesInAList;
use Noneo\Sdk\Lemlist\Requests\Companies\CreateCompaniesInTheCrm;
use Noneo\Sdk\Lemlist\Requests\Companies\CreateCompanyList;
use Noneo\Sdk\Lemlist\Requests\Companies\CreateCompanyNote;
use Noneo\Sdk\Lemlist\Requests\Companies\DeleteCompany;
use Noneo\Sdk\Lemlist\Requests\Companies\EngageCompany;
use Noneo\Sdk\Lemlist\Requests\Companies\GetCompany;
use Noneo\Sdk\Lemlist\Requests\Companies\GetCompanyLists;
use Noneo\Sdk\Lemlist\Requests\Companies\GetCompanyNotes;
use Noneo\Sdk\Lemlist\Requests\Companies\GetManyCompanies;
use Noneo\Sdk\Lemlist\Requests\Companies\MergeCompanies;
use Noneo\Sdk\Lemlist\Requests\Companies\SearchConnectCompaniesInTheCrm;

/**
 * Section « Companies » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Companies
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Get Many Companies.
     *
     * `GET /companies`
     *
     * @param string|null $idsOrDomains         Comma-separated list of company IDs or domains to fetch
     * @param string|null $crmIds               Comma-separated record ids of companies in the CRM connected to the team (HubSpot, Salesforce, or Pipedrive); for Salesforce, the 18-character Account id
     * @param int|null    $offset               Number of companies to skip for pagination
     * @param string|null $sortBy               The field by which to sort (valeurs : createdAt)
     * @param string|null $sortOrder            The sort direction (valeurs : asc, desc)
     * @param string|null $search               Search by company name (case insensitive)
     * @param string|null $fields               Returns selected fields
     * @param int|null    $limit                Number of companies to retrieve
     * @param string|null $listId               Filter companies to the members of a CRM company list (`clt_xxx` format): a static list, or a dynamic list kept in sync with its filters
     * @param string|null $crmSyncStatus        Filter companies by their CRM sync state against the team's active CRM provider (valeurs : synced, not_synced, error, searching, not_found, unique_index_error_company, property_doesnt_exist, required_field_missing, company_already_exists_with_name, company_already_exists_with_linkedin_url)
     * @param string|null $fieldRejectionReason Filter companies to those carrying a field rejection with this reason — a value lemlist refused to write, raised during CRM sync (`crm_sync_*`)
     *
     * @return array<array-key, mixed>
     */
    public function getManyCompanies(
        ?string $idsOrDomains = null,
        ?string $crmIds = null,
        ?int $offset = null,
        ?string $sortBy = null,
        ?string $sortOrder = null,
        ?string $search = null,
        ?string $fields = null,
        ?int $limit = null,
        ?string $listId = null,
        ?string $crmSyncStatus = null,
        ?string $fieldRejectionReason = null,
    ): array {
        $response = $this->connector->send(new GetManyCompanies(
            idsOrDomains: $idsOrDomains,
            crmIds: $crmIds,
            offset: $offset,
            sortBy: $sortBy,
            sortOrder: $sortOrder,
            search: $search,
            fields: $fields,
            limit: $limit,
            listId: $listId,
            crmSyncStatus: $crmSyncStatus,
            fieldRejectionReason: $fieldRejectionReason,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Add and update company.
     *
     * `POST /companies`
     *
     * @param string|null          $companyId           Existing company ID
     * @param string|null          $name                Company name
     * @param string|null          $domain              Company website domain (e.g
     * @param string|null          $linkedinUrl         LinkedIn company page URL
     * @param string|null          $linkedinUrlSalesNav LinkedIn Sales Navigator company URL
     * @param string|null          $companyOwner        Owner of the company
     * @param string|null          $industry            Industry sector of the company
     * @param string|null          $location            Geographic location of the company
     * @param string|null          $size                Company size
     * @param string|null          $specialties         Company specialties
     * @param string|null          $tagline             Company tagline
     * @param string|null          $type                Company type
     * @param string|null          $description         Company description
     * @param string|null          $foundedOn           Company founding date
     * @param string|null          $headquarters        Company headquarters location
     * @param string|null          $picture             URL of the company logo or picture
     * @param string|null          $source              Origin of the company record
     * @param string|null          $crmId               Reserved for this link, never written to a custom field
     * @param string|null          $updateStrategy      What an existing record keeps (valeurs : overwrite, overwriteIgnoreEmpty, fillEmptyOnly)
     * @param array<string, mixed> $additional          champs supplémentaires, envoyés tels quels (variables personnalisées…)
     *
     * @return array<array-key, mixed>
     */
    public function addAndUpdateCompany(
        ?string $companyId = null,
        ?string $name = null,
        ?string $domain = null,
        ?string $linkedinUrl = null,
        ?string $linkedinUrlSalesNav = null,
        ?string $companyOwner = null,
        ?string $industry = null,
        ?string $location = null,
        ?string $size = null,
        ?string $specialties = null,
        ?string $tagline = null,
        ?string $type = null,
        ?string $description = null,
        ?string $foundedOn = null,
        ?string $headquarters = null,
        ?string $picture = null,
        ?string $source = null,
        ?string $crmId = null,
        ?string $updateStrategy = null,
        array $additional = [],
    ): array {
        $response = $this->connector->send(new AddAndUpdateCompany(
            companyId: $companyId,
            name: $name,
            domain: $domain,
            linkedinUrl: $linkedinUrl,
            linkedinUrlSalesNav: $linkedinUrlSalesNav,
            companyOwner: $companyOwner,
            industry: $industry,
            location: $location,
            size: $size,
            specialties: $specialties,
            tagline: $tagline,
            type: $type,
            description: $description,
            foundedOn: $foundedOn,
            headquarters: $headquarters,
            picture: $picture,
            source: $source,
            crmId: $crmId,
            updateStrategy: $updateStrategy,
            additional: $additional,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Company Lists.
     *
     * `GET /companies/lists`
     *
     * @param string|null $search Filter lists by name (case-insensitive partial match)
     *
     * @return array<array-key, mixed>
     */
    public function getCompanyLists(?string $search = null): array
    {
        $response = $this->connector->send(new GetCompanyLists(search: $search));

        return ResponseDecoder::object($response);
    }

    /**
     * Create Company List.
     *
     * `POST /companies/lists`
     *
     * @param string $name Name of the company list to create (max 200 characters)
     *
     * @return array<array-key, mixed>
     */
    public function createCompanyList(string $name): array
    {
        $response = $this->connector->send(new CreateCompanyList(name: $name));

        return ResponseDecoder::object($response);
    }

    /**
     * Add or Remove Companies in a List.
     *
     * `POST /companies/lists/{listId}/entities`
     *
     * @param string       $listId     The unique identifier of the company list (`clt_xxx` format)
     * @param list<string> $companyIds Array of company IDs (`cpn_xxx` format) to add to or remove from the list
     * @param string|null  $action     Omit to **add** the companies to the list (valeurs : remove)
     *
     * @return array<array-key, mixed>
     */
    public function addOrRemoveCompaniesInAList(
        string $listId,
        array $companyIds,
        ?string $action = null,
    ): array {
        $response = $this->connector->send(new AddOrRemoveCompaniesInAList(
            listId: $listId,
            companyIds: $companyIds,
            action: $action,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Merge Companies.
     *
     * `POST /companies/merge`
     *
     * @param string       $primaryId    The surviving company
     * @param list<string> $secondaryIds The companies folded into the survivor then deleted, 9 at most
     *
     * @return array<array-key, mixed>
     */
    public function mergeCompanies(string $primaryId, array $secondaryIds): array
    {
        $response = $this->connector->send(new MergeCompanies(primaryId: $primaryId, secondaryIds: $secondaryIds));

        return ResponseDecoder::object($response);
    }

    /**
     * Search & Connect Companies in the CRM.
     *
     * `POST /companies/crm/search-and-connect`
     *
     * @param list<string>|null $idsOrDomains lemlist company ids (`cpn_xxx`) or domains, 10,000 at most
     * @param string|null       $listId       A company list id (`clt_xxx`): acts on every company of the list, static or dynamic, 10,000 at most
     *
     * @return array<array-key, mixed>
     */
    public function searchConnectCompaniesInTheCrm(?array $idsOrDomains = null, ?string $listId = null): array
    {
        $response = $this->connector->send(new SearchConnectCompaniesInTheCrm(idsOrDomains: $idsOrDomains, listId: $listId));

        return ResponseDecoder::object($response);
    }

    /**
     * Create Companies in the CRM.
     *
     * `POST /companies/crm/create`
     *
     * @param list<string>|null $idsOrDomains lemlist company ids (`cpn_xxx`) or domains, 10,000 at most
     * @param string|null       $listId       A company list id (`clt_xxx`): acts on every company of the list, static or dynamic, 10,000 at most
     *
     * @return array<array-key, mixed>
     */
    public function createCompaniesInTheCrm(?array $idsOrDomains = null, ?string $listId = null): array
    {
        $response = $this->connector->send(new CreateCompaniesInTheCrm(idsOrDomains: $idsOrDomains, listId: $listId));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Company.
     *
     * `GET /companies/{companyId}`
     *
     * @param string $companyId The lemlist company ID
     */
    public function getCompany(string $companyId): CompanyDto
    {
        $response = $this->connector->send(new GetCompany(companyId: $companyId));

        return CompanyDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Delete Company.
     *
     * `DELETE /companies/{companyId}`
     *
     * @param string    $companyId The lemlist company ID to delete
     * @param bool|null $force     When `true`, detaches contacts attached to this company (unsets their `companyId`) before deleting it
     *
     * @return array<array-key, mixed>
     */
    public function deleteCompany(string $companyId, ?bool $force = null): array
    {
        $response = $this->connector->send(new DeleteCompany(companyId: $companyId, force: $force));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Company Notes.
     *
     * `GET /companies/{companyId}/notes`
     *
     * @param string      $companyId The unique identifier of the company
     * @param int|null    $limit     Number of notes to retrieve
     * @param int|null    $page      Page number to retrieve
     * @param string|null $sortBy    The field by which to sort (valeurs : createdAt)
     * @param string|null $sortOrder The sort direction (valeurs : asc, desc)
     *
     * @return array<array-key, mixed>
     */
    public function getCompanyNotes(
        string $companyId,
        ?int $limit = null,
        ?int $page = null,
        ?string $sortBy = null,
        ?string $sortOrder = null,
    ): array {
        $response = $this->connector->send(new GetCompanyNotes(
            companyId: $companyId,
            limit: $limit,
            page: $page,
            sortBy: $sortBy,
            sortOrder: $sortOrder,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Create Company Note.
     *
     * `POST /companies/{companyId}/notes`
     *
     * @param string $companyId The unique identifier of the company
     * @param string $note      The note content
     */
    public function createCompanyNote(string $companyId, string $note): CompanyNoteDto
    {
        $response = $this->connector->send(new CreateCompanyNote(companyId: $companyId, note: $note));

        return CompanyNoteDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Engage Company.
     *
     * `POST /companies/{companyId}/engage`
     *
     * @param string $companyId The company to engage
     */
    public function engageCompany(string $companyId): mixed
    {
        $response = $this->connector->send(new EngageCompany(companyId: $companyId));

        return ResponseDecoder::value($response);
    }
}
