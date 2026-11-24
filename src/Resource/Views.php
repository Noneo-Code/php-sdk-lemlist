<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\ViewRefResponseDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Views\CreateView;
use Noneo\Sdk\Lemlist\Requests\Views\DeleteView;
use Noneo\Sdk\Lemlist\Requests\Views\DuplicateView;
use Noneo\Sdk\Lemlist\Requests\Views\GetViewFields;
use Noneo\Sdk\Lemlist\Requests\Views\ListViews;
use Noneo\Sdk\Lemlist\Requests\Views\SetViewTabs;
use Noneo\Sdk\Lemlist\Requests\Views\UpdateView;

/**
 * Section « Views » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Views
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * List Views.
     *
     * `GET /views`
     *
     * @param string $entity The list: `contact` (Contacts page), `company` (Companies page) or `task` (Tasks page) (valeurs : contact, company, task)
     *
     * @return array<array-key, mixed>
     */
    public function listViews(string $entity): array
    {
        $response = $this->connector->send(new ListViews(entity: $entity));

        return ResponseDecoder::object($response);
    }

    /**
     * Create View.
     *
     * `POST /views`
     *
     * @param string                          $entity     The list a view belongs to: `contact` (Contacts page), `company` (Companies page) or `task` (Tasks page) (valeurs : contact, company, task)
     * @param string                          $name       Name shown on the tab, 1 to 80 characters after trimming
     * @param string|null                     $icon       Font Awesome icon shown on the tab
     * @param string|null                     $visibility `me`: private to its owner (valeurs : me, everyone)
     * @param array<string, mixed>|null       $filters    A view's filters
     * @param array<string, mixed>|null       $sort       Task views only: the sort, on one column
     * @param list<array<string, mixed>>|null $columns    Task views only: the visible columns, in order
     */
    public function createView(
        string $entity,
        string $name,
        ?string $icon = null,
        ?string $visibility = null,
        ?array $filters = null,
        ?array $sort = null,
        ?array $columns = null,
    ): ViewRefResponseDto {
        $response = $this->connector->send(new CreateView(
            entity: $entity,
            name: $name,
            icon: $icon,
            visibility: $visibility,
            filters: $filters,
            sort: $sort,
            columns: $columns,
        ));

        return ViewRefResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Get View Fields.
     *
     * `GET /views/fields`
     *
     * @param string $entity The list: `contact` (Contacts page), `company` (Companies page) or `task` (Tasks page) (valeurs : contact, company, task)
     *
     * @return array<array-key, mixed>
     */
    public function getViewFields(string $entity): array
    {
        $response = $this->connector->send(new GetViewFields(entity: $entity));

        return ResponseDecoder::object($response);
    }

    /**
     * Set View Tabs.
     *
     * `PUT /views/tabs`
     *
     * @param string       $entity The list a view belongs to: `contact` (Contacts page), `company` (Companies page) or `task` (Tasks page) (valeurs : contact, company, task)
     * @param list<string> $pinned Ids of the views to show as tabs, in tab order
     *
     * @return array<array-key, mixed>
     */
    public function setViewTabs(string $entity, array $pinned): array
    {
        $response = $this->connector->send(new SetViewTabs(entity: $entity, pinned: $pinned));

        return ResponseDecoder::object($response);
    }

    /**
     * Update View.
     *
     * `PATCH /views/{viewId}`
     *
     * @param string                          $viewId     Id of the view, from [List Views](/api-reference/endpoints/views/list-views)
     * @param string                          $entity     The list a view belongs to: `contact` (Contacts page), `company` (Companies page) or `task` (Tasks page) (valeurs : contact, company, task)
     * @param string|null                     $name       Name shown on the tab, 1 to 80 characters after trimming
     * @param string|null                     $icon       Font Awesome icon shown on the tab
     * @param string|null                     $visibility `me`: private to its owner (valeurs : me, everyone)
     * @param array<string, mixed>|null       $filters    A view's filters
     * @param array<string, mixed>|null       $sort       Task views only: the sort, on one column
     * @param list<array<string, mixed>>|null $columns    Task views only: the visible columns, in order
     */
    public function updateView(
        string $viewId,
        string $entity,
        ?string $name = null,
        ?string $icon = null,
        ?string $visibility = null,
        ?array $filters = null,
        ?array $sort = null,
        ?array $columns = null,
    ): ViewRefResponseDto {
        $response = $this->connector->send(new UpdateView(
            viewId: $viewId,
            entity: $entity,
            name: $name,
            icon: $icon,
            visibility: $visibility,
            filters: $filters,
            sort: $sort,
            columns: $columns,
        ));

        return ViewRefResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Delete View.
     *
     * `DELETE /views/{viewId}`
     *
     * @param string $viewId Id of the view, from [List Views](/api-reference/endpoints/views/list-views)
     * @param string $entity The list: `contact` (Contacts page), `company` (Companies page) or `task` (Tasks page) (valeurs : contact, company, task)
     *
     * @return array<array-key, mixed>
     */
    public function deleteView(string $viewId, string $entity): array
    {
        $response = $this->connector->send(new DeleteView(viewId: $viewId, entity: $entity));

        return ResponseDecoder::object($response);
    }

    /**
     * Duplicate View.
     *
     * `POST /views/{viewId}/duplicate`
     *
     * @param string $viewId Id of the view, from [List Views](/api-reference/endpoints/views/list-views)
     * @param string $entity The list a view belongs to: `contact` (Contacts page), `company` (Companies page) or `task` (Tasks page) (valeurs : contact, company, task)
     *
     * @return array<array-key, mixed>
     */
    public function duplicateView(string $viewId, string $entity): array
    {
        $response = $this->connector->send(new DuplicateView(viewId: $viewId, entity: $entity));

        return ResponseDecoder::object($response);
    }
}
