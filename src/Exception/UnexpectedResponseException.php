<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Exception;

/**
 * La réponse est un succès HTTP, mais son corps n'a pas la forme attendue :
 * JSON invalide, ou scalaire là où un objet était documenté.
 */
final class UnexpectedResponseException extends LemlistException
{
    /**
     * @internal
     */
    public static function forBody(string $reason, int $status, string $body): self
    {
        return new self($reason, $status, [], [], self::truncate($body, self::MAX_BODY_LENGTH));
    }
}
