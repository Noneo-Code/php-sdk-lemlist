<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Exception;

/**
 * Erreur 4xx sans exception dédiée. Garantit qu'aucune réponse en échec ne
 * s'échappe sous la forme d'une exception Saloon : `catch (LemlistException)`
 * couvre toute la surface d'erreur du SDK.
 */
final class ClientException extends LemlistException
{
}
