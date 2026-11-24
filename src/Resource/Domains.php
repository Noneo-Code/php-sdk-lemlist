<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Domains\ListDomainMailboxes;
use Noneo\Sdk\Lemlist\Requests\Domains\ListDomains;
use Noneo\Sdk\Lemlist\Requests\Domains\OrderDomainMailboxes;
use Noneo\Sdk\Lemlist\Requests\Domains\PurchaseDomain;
use Noneo\Sdk\Lemlist\Requests\Domains\SearchDomains;
use Noneo\Sdk\Lemlist\Requests\Domains\UpdateDomainMailbox;

/**
 * Section « Domains » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Domains
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Search Domains.
     *
     * `POST /domains-core/search`
     *
     * @param string    $base               A full domain name to check
     * @param bool|null $includeSuggestions Also check variants on `.com`, `.net` and `.ai` and with or without a `get` prefix, up to 9 names in total
     *
     * @return array<array-key, mixed>
     */
    public function searchDomains(string $base, ?bool $includeSuggestions = null): array
    {
        $response = $this->connector->send(new SearchDomains(base: $base, includeSuggestions: $includeSuggestions));

        return ResponseDecoder::object($response);
    }

    /**
     * List Domains.
     *
     * `GET /domains-core/team-domains`
     *
     * @return array<array-key, mixed>
     */
    public function listDomains(): array
    {
        $response = $this->connector->send(new ListDomains());

        return ResponseDecoder::object($response);
    }

    /**
     * Purchase Domain.
     *
     * `POST /domains-core/purchase`
     *
     * @param string                          $domain         Domain to buy or transfer
     * @param string|null                     $provider       Mailbox provider of the domain, permanent: `google` (Google Workspace), `m365` (Microsoft 365) or `infraforge` (SMTP) (valeurs : google, m365, infraforge)
     * @param bool|null                       $isTransfer     Transfer a domain registered elsewhere instead of registering a new one
     * @param string|null                     $authCode       Transfer authorization code from the current registrar
     * @param list<array<string, mixed>>|null $dnsRecords     Transfer only: records to recreate on the zone once the transfer completes
     * @param array<string, mixed>|null       $billingContact Registrant contact of the team, sent to the registrar
     *
     * @return array<array-key, mixed>
     */
    public function purchaseDomain(
        string $domain,
        ?string $provider = null,
        ?bool $isTransfer = null,
        ?string $authCode = null,
        ?array $dnsRecords = null,
        ?array $billingContact = null,
    ): array {
        $response = $this->connector->send(new PurchaseDomain(
            domain: $domain,
            provider: $provider,
            isTransfer: $isTransfer,
            authCode: $authCode,
            dnsRecords: $dnsRecords,
            billingContact: $billingContact,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Order Mailboxes.
     *
     * `POST /domains-core/{domainId}/mailboxes`
     *
     * @param string                     $domainId The domain, from List Domains or Purchase Domain
     * @param list<array<string, mixed>> $emails
     *
     * @return array<array-key, mixed>
     */
    public function orderDomainMailboxes(string $domainId, array $emails): array
    {
        $response = $this->connector->send(new OrderDomainMailboxes(domainId: $domainId, emails: $emails));

        return ResponseDecoder::object($response);
    }

    /**
     * List Domain Mailboxes.
     *
     * `GET /domains-core/mailboxes`
     *
     * @param string|null $domainId Only the mailboxes of this domain
     *
     * @return array<array-key, mixed>
     */
    public function listDomainMailboxes(?string $domainId = null): array
    {
        $response = $this->connector->send(new ListDomainMailboxes(domainId: $domainId));

        return ResponseDecoder::object($response);
    }

    /**
     * Update Domain Mailbox.
     *
     * `PATCH /domains-core/mailboxes/{mailboxId}`
     *
     * @param string $mailboxId      The mailbox, from List Domain Mailboxes or Order Mailboxes
     * @param string $assignToUserId Team member who will send from the mailbox
     *
     * @return array<array-key, mixed>
     */
    public function updateDomainMailbox(string $mailboxId, string $assignToUserId): array
    {
        $response = $this->connector->send(new UpdateDomainMailbox(mailboxId: $mailboxId, assignToUserId: $assignToUserId));

        return ResponseDecoder::object($response);
    }
}
