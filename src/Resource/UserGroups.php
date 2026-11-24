<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\UserGroupDeleteResponseDto;
use Noneo\Sdk\Lemlist\Dto\UserGroupListResponseDto;
use Noneo\Sdk\Lemlist\Dto\UserGroupResponseDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\UserGroups\CreateUserGroup;
use Noneo\Sdk\Lemlist\Requests\UserGroups\DeleteUserGroup;
use Noneo\Sdk\Lemlist\Requests\UserGroups\EditUserGroupMembers;
use Noneo\Sdk\Lemlist\Requests\UserGroups\GetUserGroup;
use Noneo\Sdk\Lemlist\Requests\UserGroups\ListUserGroups;
use Noneo\Sdk\Lemlist\Requests\UserGroups\UpdateUserGroup;

/**
 * Section « UserGroups » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class UserGroups
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * List User Groups.
     *
     * `GET /v2/user-groups`
     */
    public function listUserGroups(): UserGroupListResponseDto
    {
        $response = $this->connector->send(new ListUserGroups());

        return UserGroupListResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Create User Group.
     *
     * `POST /v2/user-groups`
     *
     * @param string       $name    Unique in the team, whatever its case
     * @param list<string> $userIds Ids of team members; `[]` for an empty group
     */
    public function createUserGroup(string $name, array $userIds): UserGroupResponseDto
    {
        $response = $this->connector->send(new CreateUserGroup(name: $name, userIds: $userIds));

        return UserGroupResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Get User Group.
     *
     * `GET /v2/user-groups/{userGroupId}`
     *
     * @param string $userGroupId Id of the group, as returned by the list endpoint
     */
    public function getUserGroup(string $userGroupId): UserGroupResponseDto
    {
        $response = $this->connector->send(new GetUserGroup(userGroupId: $userGroupId));

        return UserGroupResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Update User Group.
     *
     * `PATCH /v2/user-groups/{userGroupId}`
     *
     * @param string            $userGroupId Id of the group, as returned by the list endpoint
     * @param string|null       $name        Unique in the team, whatever its case
     * @param list<string>|null $userIds     The whole member list, replacing the previous one; `[]` empties the group
     */
    public function updateUserGroup(
        string $userGroupId,
        ?string $name = null,
        ?array $userIds = null,
    ): UserGroupResponseDto {
        $response = $this->connector->send(new UpdateUserGroup(
            userGroupId: $userGroupId,
            name: $name,
            userIds: $userIds,
        ));

        return UserGroupResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Delete User Group.
     *
     * `DELETE /v2/user-groups/{userGroupId}`
     *
     * @param string $userGroupId Id of the group, as returned by the list endpoint
     */
    public function deleteUserGroup(string $userGroupId): UserGroupDeleteResponseDto
    {
        $response = $this->connector->send(new DeleteUserGroup(userGroupId: $userGroupId));

        return UserGroupDeleteResponseDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Edit User Group Members.
     *
     * `POST /v2/user-groups/{userGroupId}/members`
     *
     * @param string            $userGroupId   Id of the group, as returned by the list endpoint
     * @param list<string>|null $addUserIds    Team members added to the group; one already in it stays once
     * @param list<string>|null $removeUserIds Users removed from the group; one not in it is ignored
     */
    public function editUserGroupMembers(
        string $userGroupId,
        ?array $addUserIds = null,
        ?array $removeUserIds = null,
    ): UserGroupResponseDto {
        $response = $this->connector->send(new EditUserGroupMembers(
            userGroupId: $userGroupId,
            addUserIds: $addUserIds,
            removeUserIds: $removeUserIds,
        ));

        return UserGroupResponseDto::fromArray(ResponseDecoder::object($response));
    }
}
