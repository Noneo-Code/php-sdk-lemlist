<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

/**
 * Points d'entrée de la façade {@see \Noneo\Sdk\Lemlist\Lemlist}, un par section de l'API.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
trait ResourceAccessors
{
    public function activities(): Activities
    {
        return new Activities($this->connector);
    }

    public function calls(): Calls
    {
        return new Calls($this->connector);
    }

    public function campaigns(): Campaigns
    {
        return new Campaigns($this->connector);
    }

    public function companies(): Companies
    {
        return new Companies($this->connector);
    }

    public function contactSourcing(): ContactSourcing
    {
        return new ContactSourcing($this->connector);
    }

    public function contacts(): Contacts
    {
        return new Contacts($this->connector);
    }

    public function crms(): Crms
    {
        return new Crms($this->connector);
    }

    public function deliverabilityAlerts(): DeliverabilityAlerts
    {
        return new DeliverabilityAlerts($this->connector);
    }

    public function domains(): Domains
    {
        return new Domains($this->connector);
    }

    public function emailAccounts(): EmailAccounts
    {
        return new EmailAccounts($this->connector);
    }

    public function enrich(): Enrich
    {
        return new Enrich($this->connector);
    }

    public function enrichmentProviders(): EnrichmentProviders
    {
        return new EnrichmentProviders($this->connector);
    }

    public function enrichmentWaterfalls(): EnrichmentWaterfalls
    {
        return new EnrichmentWaterfalls($this->connector);
    }

    public function fields(): Fields
    {
        return new Fields($this->connector);
    }

    public function inbox(): Inbox
    {
        return new Inbox($this->connector);
    }

    public function leads(): Leads
    {
        return new Leads($this->connector);
    }

    public function messageTemplates(): MessageTemplates
    {
        return new MessageTemplates($this->connector);
    }

    public function peopleDatabase(): PeopleDatabase
    {
        return new PeopleDatabase($this->connector);
    }

    public function schedules(): Schedules
    {
        return new Schedules($this->connector);
    }

    public function selfRecovery(): SelfRecovery
    {
        return new SelfRecovery($this->connector);
    }

    public function senderPicture(): SenderPicture
    {
        return new SenderPicture($this->connector);
    }

    public function senders(): Senders
    {
        return new Senders($this->connector);
    }

    public function sequences(): Sequences
    {
        return new Sequences($this->connector);
    }

    public function signalAgents(): SignalAgents
    {
        return new SignalAgents($this->connector);
    }

    public function snippets(): Snippets
    {
        return new Snippets($this->connector);
    }

    public function tasks(): Tasks
    {
        return new Tasks($this->connector);
    }

    public function team(): Team
    {
        return new Team($this->connector);
    }

    public function unsubscribes(): Unsubscribes
    {
        return new Unsubscribes($this->connector);
    }

    public function userGroups(): UserGroups
    {
        return new UserGroups($this->connector);
    }

    public function users(): Users
    {
        return new Users($this->connector);
    }

    public function views(): Views
    {
        return new Views($this->connector);
    }

    public function warmup(): Warmup
    {
        return new Warmup($this->connector);
    }

    public function webhooks(): Webhooks
    {
        return new Webhooks($this->connector);
    }
}
