<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\EmailAccounts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Test Email Account — `POST /user/email-accounts/{emailAccountId}/test`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class TestEmailAccount extends Request
{
    protected Method $method = Method::POST;

    public function __construct(private readonly string $emailAccountId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/user/email-accounts/'.rawurlencode($this->emailAccountId).'/test';
    }
}
