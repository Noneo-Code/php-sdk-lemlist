<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Concerns;

use Noneo\Sdk\Lemlist\Exception\LemlistException;
use Saloon\Enums\PipeOrder;
use Saloon\Http\PendingRequest;
use Saloon\Http\Response;

trait HandlesLemlistErrors
{
    /**
     * Équivalent du plugin `AlwaysThrowOnErrors` de Saloon, réécrit ici pour
     * une seule raison : sa closure ne marque pas la `Response` comme sensible,
     * si bien qu'elle afficherait la clé d'API dans les arguments de trace de toute
     * exception levée. La nôtre le fait.
     */
    public function bootHandlesLemlistErrors(PendingRequest $pendingRequest): void
    {
        $pendingRequest->middleware()->onResponse(
            callable: static fn (#[\SensitiveParameter] Response $response) => $response->throw(),
            name: 'lemlistThrowOnErrors',
            order: PipeOrder::LAST,
        );
    }

    /**
     * Le seuil est à 300, pas à 400 : les redirections n'étant pas suivies, un
     * 3xx est une réponse que l'appelant n'obtiendra jamais — le taire lui
     * rendrait un corps vide au lieu d'une erreur.
     */
    public function hasRequestFailed(#[\SensitiveParameter] Response $response): ?bool
    {
        return $response->status() >= 300;
    }

    /**
     * `$response` est marquée sensible : elle mène au `PendingRequest` et donc
     * à l'en-tête `Authorization`. Sans l'attribut, cette frame afficherait la
     * clé d'API dans toute trace conservant ses arguments.
     */
    public function getRequestException(#[\SensitiveParameter] Response $response, ?\Throwable $senderException): ?\Throwable
    {
        return LemlistException::fromResponse($response);
    }
}
