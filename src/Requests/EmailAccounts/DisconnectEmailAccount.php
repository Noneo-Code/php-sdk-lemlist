<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\EmailAccounts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Disconnect Email Account — `DELETE /user/email-accounts/{emailAccountId}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DisconnectEmailAccount extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(private readonly string $emailAccountId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/user/email-accounts/'.rawurlencode($this->emailAccountId);
    }
}
