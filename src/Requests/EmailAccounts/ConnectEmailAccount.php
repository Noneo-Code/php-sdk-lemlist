<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\EmailAccounts;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Connect Email Account — `POST /user/email-accounts`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class ConnectEmailAccount extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $sender_name,
        private readonly string $sender_email,
        private readonly string $smtp_host,
        private readonly int $smtp_port,
        private readonly string $smtp_login,
        #[\SensitiveParameter] private readonly string $smtp_password,
        private readonly string $imap_host,
        private readonly int $imap_port,
        private readonly string $imap_login,
        #[\SensitiveParameter] private readonly string $imap_password,
        private readonly ?bool $smtp_secure = null,
        private readonly ?bool $imap_secure = null,
        private readonly ?string $userId = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/user/email-accounts';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'sender_name' => $this->sender_name,
            'sender_email' => $this->sender_email,
            'smtp_host' => $this->smtp_host,
            'smtp_port' => $this->smtp_port,
            'smtp_login' => $this->smtp_login,
            'smtp_password' => $this->smtp_password,
            'imap_host' => $this->imap_host,
            'imap_port' => $this->imap_port,
            'imap_login' => $this->imap_login,
            'imap_password' => $this->imap_password,
            'smtp_secure' => $this->smtp_secure,
            'imap_secure' => $this->imap_secure,
            'userId' => $this->userId,
        ]);
    }
}
