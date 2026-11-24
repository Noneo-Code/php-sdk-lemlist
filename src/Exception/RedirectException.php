<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Exception;

/**
 * L'API Lemlist ne redirige pas. Un 3xx signale donc un intermédiaire — bon
 * ou mauvais — sur le trajet : le SDK ne le suit pas (`allow_redirects` est
 * désactivé) et le remonte tel quel plutôt que de rejouer l'en-tête
 * `Authorization` vers l'hôte annoncé.
 */
final class RedirectException extends LemlistException
{
    public function location(): ?string
    {
        return $this->responseHeaders()['Location'] ?? null;
    }
}
