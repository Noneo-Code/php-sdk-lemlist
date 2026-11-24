<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\DatabaseFilterDto;
use Noneo\Sdk\Lemlist\Dto\PersonaCreateResponseDto;
use Noneo\Sdk\Lemlist\Dto\PersonaDeleteResponseDto;
use Noneo\Sdk\Lemlist\Dto\PersonaListResponseDto;
use Noneo\Sdk\Lemlist\Dto\SavedSearchCreateResponseDto;
use Noneo\Sdk\Lemlist\Dto\SavedSearchDeleteResponseDto;
use Noneo\Sdk\Lemlist\Dto\SavedSearchListResponseDto;
use Noneo\Sdk\Lemlist\Dto\SavedSearchResponseDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\PeopleDatabase\CreatePersona;
use Noneo\Sdk\Lemlist\Requests\PeopleDatabase\CreateSavedSearch;
use Noneo\Sdk\Lemlist\Requests\PeopleDatabase\DeletePersona;
use Noneo\Sdk\Lemlist\Requests\PeopleDatabase\DeleteSavedSearch;
use Noneo\Sdk\Lemlist\Requests\PeopleDatabase\ExportCompaniesDatabaseSearch;
use Noneo\Sdk\Lemlist\Requests\PeopleDatabase\ExportPeopleDatabaseSearch;
use Noneo\Sdk\Lemlist\Requests\PeopleDatabase\GetDatabaseFilters;
use Noneo\Sdk\Lemlist\Requests\PeopleDatabase\GetSavedSearch;
use Noneo\Sdk\Lemlist\Requests\PeopleDatabase\ListPersonas;
use Noneo\Sdk\Lemlist\Requests\PeopleDatabase\ListSavedSearches;
use Noneo\Sdk\Lemlist\Requests\PeopleDatabase\SearchCompaniesDatabase;
use Noneo\Sdk\Lemlist\Requests\PeopleDatabase\SearchLinkedInPostEngagers;
use Noneo\Sdk\Lemlist\Requests\PeopleDatabase\SearchPeopleDatabase;
use Noneo\Sdk\Lemlist\Requests\PeopleDatabase\UpdateSavedSearch;

/**
 * Section « PeopleDatabase » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class PeopleDatabase
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Get Database Filters.
     *
     * `GET /database/filters`
     *
     * @param string|null $usage Context the filters will be used in (valeurs : api, ui)
     * @param string|null $mode  Restrict the list to the filters of one search mode (valeurs : leads, companies)
     *
     * @return list<DatabaseFilterDto>
     */
    public function getDatabaseFilters(?string $usage = null, ?string $mode = null): array
    {
        $response = $this->connector->send(new GetDatabaseFilters(usage: $usage, mode: $mode));

        return array_map(DatabaseFilterDto::fromArray(...), ResponseDecoder::items($response));
    }

    /**
     * Search People Database.
     *
     * `POST /database/people`
     *
     * @param list<array<string, mixed>>|null $filters      Array of filters (required, unless `fromSearchId` is provided)
     * @param string|null                     $fromSearchId Id of a previous People search of your team (not a Companies search): the `search` value returned by `POST /database/people` (optional)
     * @param int|null                        $page         Page (optional)
     * @param int|null                        $size         Size of the results, number between 1 and 100 (optional)
     * @param list<string>|null               $excludes     Array of properties to exclude from the results (optional)
     * @param string|null                     $search       Free-text query across common people fields (e.g., name, title, company, location)
     *
     * @return array<array-key, mixed>
     */
    public function searchPeopleDatabase(
        ?array $filters = null,
        ?string $fromSearchId = null,
        ?int $page = null,
        ?int $size = null,
        ?array $excludes = null,
        ?string $search = null,
    ): array {
        $response = $this->connector->send(new SearchPeopleDatabase(
            filters: $filters,
            fromSearchId: $fromSearchId,
            page: $page,
            size: $size,
            excludes: $excludes,
            search: $search,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Search LinkedIn Post Engagers.
     *
     * `POST /database/people/linkedin-post-engagement`
     *
     * @param string                          $url     Link of the LinkedIn post
     * @param string|null                     $type    Which engagers to collect (valeurs : all, comments, reactions)
     * @param list<array<string, mixed>>|null $filters People Database leads filters (optional), applied to the engagers in the same search, for example a country
     * @param int|null                        $size    Number of People Database rows returned in `data.people`, between 1 and 100 (optional)
     *
     * @return array<array-key, mixed>
     */
    public function searchLinkedInPostEngagers(
        string $url,
        ?string $type = null,
        ?array $filters = null,
        ?int $size = null,
    ): array {
        $response = $this->connector->send(new SearchLinkedInPostEngagers(
            url: $url,
            type: $type,
            filters: $filters,
            size: $size,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Search Companies Database.
     *
     * `POST /database/companies`
     *
     * @param list<array<string, mixed>>|null $filters      Array of filter objects to narrow down search results
     * @param string|null                     $fromSearchId Id of a previous Companies search of your team (not a People search): the `search` value returned by `POST /database/companies` (optional)
     * @param int|null                        $page         Page number for pagination (default: 1)
     * @param int|null                        $size         Number of results per page (default: 100, max: 500)
     *
     * @return array<array-key, mixed>
     */
    public function searchCompaniesDatabase(
        ?array $filters = null,
        ?string $fromSearchId = null,
        ?int $page = null,
        ?int $size = null,
    ): array {
        $response = $this->connector->send(new SearchCompaniesDatabase(
            filters: $filters,
            fromSearchId: $fromSearchId,
            page: $page,
            size: $size,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Export People database search.
     *
     * `GET /database/people/export`
     *
     * @param string   $filters The search to export, URL-encoded JSON array — the same `filters` array `POST /database/people` takes
     * @param int|null $limit   How many rows to export
     */
    public function exportPeopleDatabaseSearch(string $filters, ?int $limit = null): string
    {
        $response = $this->connector->send(new ExportPeopleDatabaseSearch(filters: $filters, limit: $limit));

        return ResponseDecoder::text($response);
    }

    /**
     * Export Companies database search.
     *
     * `GET /database/companies/export`
     *
     * @param string   $filters The search to export, URL-encoded JSON array — the same `filters` array `POST /database/companies` takes
     * @param int|null $limit   How many rows to export
     */
    public function exportCompaniesDatabaseSearch(string $filters, ?int $limit = null): string
    {
        $response = $this->connector->send(new ExportCompaniesDatabaseSearch(filters: $filters, limit: $limit));

        return ResponseDecoder::text($response);
    }

    /**
     * List Personas.
     *
     * `GET /database/personas`
     *
     * @param string|null $mode Restrict the list to personas of one search mode (valeurs : leads, companies)
     */
    public function listPersonas(?string $mode = null): PersonaListResponseDto
    {
        $response = $this->connector->send(new ListPersonas(mode: $mode));

        return PersonaListResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Create Persona.
     *
     * `POST /database/personas`
     *
     * @param string                     $name    Display name
     * @param list<array<string, mixed>> $filters People Database filters defining the persona
     * @param string                     $mode    Search mode the filters target (valeurs : leads, companies)
     */
    public function createPersona(
        string $name,
        array $filters,
        string $mode,
    ): PersonaCreateResponseDto {
        $response = $this->connector->send(new CreatePersona(
            name: $name,
            filters: $filters,
            mode: $mode,
        ));

        return PersonaCreateResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Delete Persona.
     *
     * `DELETE /database/personas/{personaId}`
     *
     * @param string $personaId Id of the persona to delete
     */
    public function deletePersona(string $personaId): PersonaDeleteResponseDto
    {
        $response = $this->connector->send(new DeletePersona(personaId: $personaId));

        return PersonaDeleteResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * List Saved Searches.
     *
     * `GET /database/saved-searches`
     *
     * @param string|null $mode Restrict the list to saved searches of one search mode (valeurs : leads, companies)
     */
    public function listSavedSearches(?string $mode = null): SavedSearchListResponseDto
    {
        $response = $this->connector->send(new ListSavedSearches(mode: $mode));

        return SavedSearchListResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Create Saved Search.
     *
     * `POST /database/saved-searches`
     *
     * @param string                     $name    Display name, 1 to 200 characters after trimming
     * @param list<array<string, mixed>> $filters People Database filters of the saved search
     * @param string                     $mode    Search mode the filters target (valeurs : leads, companies)
     */
    public function createSavedSearch(
        string $name,
        array $filters,
        string $mode,
    ): SavedSearchCreateResponseDto {
        $response = $this->connector->send(new CreateSavedSearch(
            name: $name,
            filters: $filters,
            mode: $mode,
        ));

        return SavedSearchCreateResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Get Saved Search.
     *
     * `GET /database/saved-searches/{savedSearchId}`
     *
     * @param string $savedSearchId Id of the saved search
     */
    public function getSavedSearch(string $savedSearchId): SavedSearchResponseDto
    {
        $response = $this->connector->send(new GetSavedSearch(savedSearchId: $savedSearchId));

        return SavedSearchResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Update Saved Search.
     *
     * `PATCH /database/saved-searches/{savedSearchId}`
     *
     * @param string                          $savedSearchId Id of the saved search
     * @param string|null                     $name          Display name, 1 to 200 characters after trimming
     * @param list<array<string, mixed>>|null $filters       New filters, replacing the saved ones entirely
     * @param string|null                     $mode          Search mode of the new `filters` (valeurs : leads, companies)
     */
    public function updateSavedSearch(
        string $savedSearchId,
        ?string $name = null,
        ?array $filters = null,
        ?string $mode = null,
    ): SavedSearchResponseDto {
        $response = $this->connector->send(new UpdateSavedSearch(
            savedSearchId: $savedSearchId,
            name: $name,
            filters: $filters,
            mode: $mode,
        ));

        return SavedSearchResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Delete Saved Search.
     *
     * `DELETE /database/saved-searches/{savedSearchId}`
     *
     * @param string $savedSearchId Id of the saved search
     */
    public function deleteSavedSearch(string $savedSearchId): SavedSearchDeleteResponseDto
    {
        $response = $this->connector->send(new DeleteSavedSearch(savedSearchId: $savedSearchId));

        return SavedSearchDeleteResponseDto::fromArray(ResponseDecoder::object($response));
    }
}
