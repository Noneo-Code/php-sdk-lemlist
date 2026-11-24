<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\MessageTemplateDto;
use Noneo\Sdk\Lemlist\Dto\MessageTemplateListResponseDto;
use Noneo\Sdk\Lemlist\Dto\MessageTemplateTagListResponseDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\MessageTemplates\GetMessageTemplate;
use Noneo\Sdk\Lemlist\Requests\MessageTemplates\ListMessageTemplates;
use Noneo\Sdk\Lemlist\Requests\MessageTemplates\ListMessageTemplateTags;

/**
 * Section « MessageTemplates » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class MessageTemplates
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * List Message Templates.
     *
     * `GET /message-templates`
     *
     * @param string|null $search  Substring of the name, case-insensitive
     * @param string|null $tags    Keep the templates carrying any of these tags
     * @param string|null $userIds Keep the items created by any of these users (`usr_` ids, see GET /team/members)
     * @param int|null    $page    Page number to retrieve, starting at 1
     * @param int|null    $limit   Number of items per page
     */
    public function listMessageTemplates(
        ?string $search = null,
        ?string $tags = null,
        ?string $userIds = null,
        ?int $page = null,
        ?int $limit = null,
    ): MessageTemplateListResponseDto {
        $response = $this->connector->send(new ListMessageTemplates(
            search: $search,
            tags: $tags,
            userIds: $userIds,
            page: $page,
            limit: $limit,
        ));

        return MessageTemplateListResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * List Message Template Tags.
     *
     * `GET /message-templates/tags`
     *
     * @param string|null $search  Substring of the name, case-insensitive
     * @param string|null $userIds Keep the items created by any of these users (`usr_` ids, see GET /team/members)
     * @param int|null    $page    Page number to retrieve, starting at 1
     * @param int|null    $limit   Number of items per page
     */
    public function listMessageTemplateTags(
        ?string $search = null,
        ?string $userIds = null,
        ?int $page = null,
        ?int $limit = null,
    ): MessageTemplateTagListResponseDto {
        $response = $this->connector->send(new ListMessageTemplateTags(
            search: $search,
            userIds: $userIds,
            page: $page,
            limit: $limit,
        ));

        return MessageTemplateTagListResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Get Message Template.
     *
     * `GET /message-templates/{templateId}`
     *
     * @param string $templateId The unique identifier of the message template, from GET /message-templates
     */
    public function getMessageTemplate(string $templateId): MessageTemplateDto
    {
        $response = $this->connector->send(new GetMessageTemplate(templateId: $templateId));

        return MessageTemplateDto::fromArray(ResponseDecoder::object($response));
    }
}
