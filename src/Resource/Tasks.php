<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\TaskDto;
use Noneo\Sdk\Lemlist\Dto\TaskV2FiltersResponseDto;
use Noneo\Sdk\Lemlist\Dto\TaskV2ListResponseDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Tasks\CreateTask;
use Noneo\Sdk\Lemlist\Requests\Tasks\IgnoreTasks;
use Noneo\Sdk\Lemlist\Requests\Tasks\ListTaskFilters;
use Noneo\Sdk\Lemlist\Requests\Tasks\SearchTasks;
use Noneo\Sdk\Lemlist\Requests\Tasks\UpdateTask;

/**
 * Section « Tasks » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Tasks
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Search Tasks.
     *
     * `GET /v2/tasks`
     *
     * @param string|null                    $taskId             Task ids
     * @param string|null                    $contactId          Contact ids
     * @param string|null                    $contactIdNot       Excludes the given `contactId` values
     * @param string|null                    $companyId          Company ids
     * @param string|null                    $companyIdNot       Excludes the given `companyId` values
     * @param string|null                    $leadId             Lead ids
     * @param string|null                    $leadIdNot          Excludes the given `leadId` values
     * @param string|null                    $campaignId         Campaign ids
     * @param string|null                    $campaignIdNot      Excludes the given `campaignId` values
     * @param string|null                    $assignedTo         Ids of the users the task is assigned to
     * @param string|null                    $assignedToNot      Excludes the given `assignedTo` values
     * @param string|null                    $objectType         Restricts to the tasks hanging off a contact (a `contactId` or a `leadId` is present) or off a company (a `companyId` with no contact and no lead) (valeurs : contact, company)
     * @param string|null                    $type               Raw step types, comma-separated
     * @param string|null                    $typeNot            Excludes the given `type` values
     * @param string|null                    $channel            Channel the task belongs to — the coarser nomenclature shown in the app as "Task type" (valeurs : aircall, email, linkedin, whatsapp, sms, manual)
     * @param string|null                    $status             Task statuses, comma-separated (valeurs : due, upcoming, paused, done, ignored, pending)
     * @param string|null                    $priority           Task priorities (integers), comma-separated
     * @param string|null                    $title              Matches tasks whose title contains this text
     * @param string|null                    $contactLinkedinUrl Matches tasks whose contact's LinkedIn URL contains this text
     * @param \DateTimeInterface|string|null $dueDateFrom        Lower bound of the due date, inclusive
     * @param \DateTimeInterface|string|null $dueDateTo          Upper bound of the due date, inclusive
     * @param \DateTimeInterface|string|null $completedAtFrom    Lower bound of the completion date (done or ignored), inclusive
     * @param \DateTimeInterface|string|null $completedAtTo      Upper bound of the completion date (done or ignored), inclusive
     * @param bool|null                      $hasCampaign        Restricts to the tasks attached to a campaign (`true`) or to the standalone ones (`false`)
     * @param bool|null                      $hasDueDate         Restricts to the tasks carrying a due date (`true`) or to those without one (`false`)
     * @param string|null                    $search             Free-text search over the task title and the contact / company text fields
     * @param string|null                    $advancedFilters    A filter tree encoded as JSON, addressing any field returned by `GET /v2/tasks/filters`
     * @param string|null                    $include            Embeds the denormalized objects already carried by the task (valeurs : contact, company, contact,company)
     * @param string|null                    $sortBy             Field to sort on (valeurs : dueDate, status, priority, assignedTo, campaignId, score, handledOn, contactJobTitle)
     * @param string|null                    $sortOrder          Sort direction (valeurs : asc, desc)
     * @param int|null                       $page               Page number, 1-based
     * @param int|null                       $limit              Page size
     */
    public function searchTasks(
        ?string $taskId = null,
        ?string $contactId = null,
        ?string $contactIdNot = null,
        ?string $companyId = null,
        ?string $companyIdNot = null,
        ?string $leadId = null,
        ?string $leadIdNot = null,
        ?string $campaignId = null,
        ?string $campaignIdNot = null,
        ?string $assignedTo = null,
        ?string $assignedToNot = null,
        ?string $objectType = null,
        ?string $type = null,
        ?string $typeNot = null,
        ?string $channel = null,
        ?string $status = null,
        ?string $priority = null,
        ?string $title = null,
        ?string $contactLinkedinUrl = null,
        \DateTimeInterface|string|null $dueDateFrom = null,
        \DateTimeInterface|string|null $dueDateTo = null,
        \DateTimeInterface|string|null $completedAtFrom = null,
        \DateTimeInterface|string|null $completedAtTo = null,
        ?bool $hasCampaign = null,
        ?bool $hasDueDate = null,
        ?string $search = null,
        ?string $advancedFilters = null,
        ?string $include = null,
        ?string $sortBy = null,
        ?string $sortOrder = null,
        ?int $page = null,
        ?int $limit = null,
    ): TaskV2ListResponseDto {
        $response = $this->connector->send(new SearchTasks(
            taskId: $taskId,
            contactId: $contactId,
            contactIdNot: $contactIdNot,
            companyId: $companyId,
            companyIdNot: $companyIdNot,
            leadId: $leadId,
            leadIdNot: $leadIdNot,
            campaignId: $campaignId,
            campaignIdNot: $campaignIdNot,
            assignedTo: $assignedTo,
            assignedToNot: $assignedToNot,
            objectType: $objectType,
            type: $type,
            typeNot: $typeNot,
            channel: $channel,
            status: $status,
            priority: $priority,
            title: $title,
            contactLinkedinUrl: $contactLinkedinUrl,
            dueDateFrom: $dueDateFrom,
            dueDateTo: $dueDateTo,
            completedAtFrom: $completedAtFrom,
            completedAtTo: $completedAtTo,
            hasCampaign: $hasCampaign,
            hasDueDate: $hasDueDate,
            search: $search,
            advancedFilters: $advancedFilters,
            include: $include,
            sortBy: $sortBy,
            sortOrder: $sortOrder,
            page: $page,
            limit: $limit,
        ));

        return TaskV2ListResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * List Task Filters.
     *
     * `GET /v2/tasks/filters`
     *
     * @param string|null $scope  Restricts the response to one section (valeurs : task, contact, company)
     * @param string|null $search Keeps the fields whose id or label contains this text
     */
    public function listTaskFilters(?string $scope = null, ?string $search = null): TaskV2FiltersResponseDto
    {
        $response = $this->connector->send(new ListTaskFilters(scope: $scope, search: $search));

        return TaskV2FiltersResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Create Task.
     *
     * `POST /tasks`
     *
     * @param string                    $type       The type of task (valeurs : email, manual, phone, linkedin, whatsapp)
     * @param string                    $assignedTo The ID of the team member assigned to the task (userId)
     * @param \DateTimeInterface|string $dueDate    The due date in ISO 8601 format (e.g., 2025-02-12T00:00:00.000Z)
     * @param string|null               $recordId   ID of the record the task is about: a contact (`ctc_`), a company (`cpn_`) or a lead (`lea_`)
     * @param string|null               $leadId     Legacy name of `recordId`, still accepted for backward compatibility
     * @param string|null               $title      Optional title of the task
     * @param string|null               $message    Optional instruction of the task, returned as `content` in the response
     * @param array<string, mixed>|null $taskData   Draft of the message to send on `email`, `linkedin` and `whatsapp` tasks, and fallback number on `phone` tasks
     * @param string|null               $priority   Priority level of the task (valeurs : , 0, 1, 2)
     * @param list<string>|null         $images     Public HTTPS URLs of images to attach to a `linkedin` task
     * @param list<string>|null         $videos     Public HTTPS URLs of videos to attach to a `linkedin` task
     */
    public function createTask(
        string $type,
        string $assignedTo,
        \DateTimeInterface|string $dueDate,
        ?string $recordId = null,
        ?string $leadId = null,
        ?string $title = null,
        ?string $message = null,
        ?array $taskData = null,
        ?string $priority = null,
        ?array $images = null,
        ?array $videos = null,
    ): TaskDto {
        $response = $this->connector->send(new CreateTask(
            type: $type,
            assignedTo: $assignedTo,
            dueDate: $dueDate,
            recordId: $recordId,
            leadId: $leadId,
            title: $title,
            message: $message,
            taskData: $taskData,
            priority: $priority,
            images: $images,
            videos: $videos,
        ));

        return TaskDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Update Task.
     *
     * `PATCH /tasks`
     *
     * @param string                         $id         The unique identifier of the task to update
     * @param string|null                    $assignedTo The ID of the team member to assign the task to (userId)
     * @param \DateTimeInterface|string|null $dueDate    Updated due date in ISO 8601 format
     * @param string|null                    $title      Updated task title
     * @param string|null                    $message    Updated task message/description
     * @param string|null                    $priority   Priority level of the task (valeurs : , 0, 1, 2)
     * @param bool|null                      $done       Mark task as completed
     * @param list<string>|null              $images     Public HTTPS URLs of images to attach to a LinkedIn task
     * @param list<string>|null              $videos     Public HTTPS URLs of videos to attach to a LinkedIn task
     */
    public function updateTask(
        string $id,
        ?string $assignedTo = null,
        \DateTimeInterface|string|null $dueDate = null,
        ?string $title = null,
        ?string $message = null,
        ?string $priority = null,
        ?bool $done = null,
        ?array $images = null,
        ?array $videos = null,
    ): TaskDto {
        $response = $this->connector->send(new UpdateTask(
            id: $id,
            assignedTo: $assignedTo,
            dueDate: $dueDate,
            title: $title,
            message: $message,
            priority: $priority,
            done: $done,
            images: $images,
            videos: $videos,
        ));

        return TaskDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Ignore Tasks.
     *
     * `POST /tasks/ignore`
     *
     * @param list<string> $ids Array of task IDs to ignore
     *
     * @return array<array-key, mixed>
     */
    public function ignoreTasks(array $ids): array
    {
        $response = $this->connector->send(new IgnoreTasks(ids: $ids));

        return ResponseDecoder::object($response);
    }
}
