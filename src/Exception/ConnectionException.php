<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Exception;

/**
 * Aucune réponse HTTP n'a été obtenue : DNS, TLS, délai dépassé, connexion
 * coupée. `status()` vaut `0`.
 *
 * L'exception d'origine n'est volontairement pas chaînée : elle retient la
 * requête signée, donc l'en-tête `Authorization`.
 */
final class ConnectionException extends LemlistException
{
    /**
     * @internal
     */
    public static function fromMessage(string $message): self
    {
        return new self($message, 0);
    }
}
