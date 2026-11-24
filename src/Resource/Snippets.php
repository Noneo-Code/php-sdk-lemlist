<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\SnippetDto;
use Noneo\Sdk\Lemlist\Dto\SnippetListResponseDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Snippets\GetSnippet;
use Noneo\Sdk\Lemlist\Requests\Snippets\ListSnippets;

/**
 * Section « Snippets » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Snippets
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * List Snippets.
     *
     * `GET /snippets`
     *
     * @param string|null $search  Substring of the name, case-insensitive
     * @param string|null $userIds Keep the items created by any of these users (`usr_` ids, see GET /team/members)
     * @param int|null    $page    Page number to retrieve, starting at 1
     * @param int|null    $limit   Number of items per page
     */
    public function listSnippets(
        ?string $search = null,
        ?string $userIds = null,
        ?int $page = null,
        ?int $limit = null,
    ): SnippetListResponseDto {
        $response = $this->connector->send(new ListSnippets(
            search: $search,
            userIds: $userIds,
            page: $page,
            limit: $limit,
        ));

        return SnippetListResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Get Snippet.
     *
     * `GET /snippets/{snippetId}`
     *
     * @param string $snippetId The unique identifier of the snippet, from GET /snippets
     */
    public function getSnippet(string $snippetId): SnippetDto
    {
        $response = $this->connector->send(new GetSnippet(snippetId: $snippetId));

        return SnippetDto::fromArray(ResponseDecoder::object($response));
    }
}
