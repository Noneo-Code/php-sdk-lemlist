<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\EmailAccounts\ConnectEmailAccount;
use Noneo\Sdk\Lemlist\Requests\EmailAccounts\DisconnectEmailAccount;
use Noneo\Sdk\Lemlist\Requests\EmailAccounts\TestEmailAccount;

/**
 * Section « EmailAccounts » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class EmailAccounts
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Connect Email Account.
     *
     * `POST /user/email-accounts`
     *
     * @param string      $sender_name   Display name for the sender
     * @param string      $sender_email  Email address used as the sender
     * @param string      $smtp_host     SMTP server hostname
     * @param int         $smtp_port     SMTP server port
     * @param string      $smtp_login    SMTP authentication login
     * @param string      $smtp_password SMTP authentication password
     * @param string      $imap_host     IMAP server hostname
     * @param int         $imap_port     IMAP server port
     * @param string      $imap_login    IMAP authentication login
     * @param string      $imap_password IMAP authentication password
     * @param bool|null   $smtp_secure   Use SSL/TLS for SMTP connection
     * @param bool|null   $imap_secure   Use SSL/TLS for IMAP connection
     * @param string|null $userId        Assign the email account to a specific team member
     *
     * @return array<array-key, mixed>
     */
    public function connectEmailAccount(
        string $sender_name,
        string $sender_email,
        string $smtp_host,
        int $smtp_port,
        string $smtp_login,
        #[\SensitiveParameter] string $smtp_password,
        string $imap_host,
        int $imap_port,
        string $imap_login,
        #[\SensitiveParameter] string $imap_password,
        ?bool $smtp_secure = null,
        ?bool $imap_secure = null,
        ?string $userId = null,
    ): array {
        $response = $this->connector->send(new ConnectEmailAccount(
            sender_name: $sender_name,
            sender_email: $sender_email,
            smtp_host: $smtp_host,
            smtp_port: $smtp_port,
            smtp_login: $smtp_login,
            smtp_password: $smtp_password,
            imap_host: $imap_host,
            imap_port: $imap_port,
            imap_login: $imap_login,
            imap_password: $imap_password,
            smtp_secure: $smtp_secure,
            imap_secure: $imap_secure,
            userId: $userId,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Disconnect Email Account.
     *
     * `DELETE /user/email-accounts/{emailAccountId}`
     *
     * @param string $emailAccountId The ID of the email account to disconnect
     *
     * @return array<array-key, mixed>
     */
    public function disconnectEmailAccount(string $emailAccountId): array
    {
        $response = $this->connector->send(new DisconnectEmailAccount(emailAccountId: $emailAccountId));

        return ResponseDecoder::object($response);
    }

    /**
     * Test Email Account.
     *
     * `POST /user/email-accounts/{emailAccountId}/test`
     *
     * @param string $emailAccountId The ID of the email account to test
     *
     * @return array<array-key, mixed>
     */
    public function testEmailAccount(string $emailAccountId): array
    {
        $response = $this->connector->send(new TestEmailAccount(emailAccountId: $emailAccountId));

        return ResponseDecoder::object($response);
    }
}
