<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\CreditsDto;
use Noneo\Sdk\Lemlist\Dto\TeamDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Team\GetTeam;
use Noneo\Sdk\Lemlist\Requests\Team\GetTeamCredits;
use Noneo\Sdk\Lemlist\Requests\Team\GetTeamCrmUsers;
use Noneo\Sdk\Lemlist\Requests\Team\GetTeamSenders;

/**
 * Section « Team » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Team
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Get Team.
     *
     * `GET /team`
     *
     * @param string|null $version Set to `v2` to include the `users` array, listing each team member's `userId`, `name`, `email`, and `role` (valeurs : v2)
     */
    public function getTeam(?string $version = null): TeamDto
    {
        $response = $this->connector->send(new GetTeam(version: $version));

        return TeamDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Get Team Senders.
     *
     * `GET /team/senders`
     *
     * @param string|null $state Filter by campaign's state (running, paused, draft, ended, archived, errors) (valeurs : running, paused, draft, ended, archived, errors)
     *
     * @return array<array-key, mixed>
     */
    public function getTeamSenders(?string $state = null): array
    {
        $response = $this->connector->send(new GetTeamSenders(state: $state));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Team Credits.
     *
     * `GET /team/credits`
     */
    public function getTeamCredits(): CreditsDto
    {
        $response = $this->connector->send(new GetTeamCredits());

        return CreditsDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Get Team CRM Users.
     *
     * `GET /team/crmUsers`
     *
     * @return array<array-key, mixed>
     */
    public function getTeamCrmUsers(): array
    {
        $response = $this->connector->send(new GetTeamCrmUsers());

        return ResponseDecoder::object($response);
    }
}
