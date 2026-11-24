<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\LeadV2Dto;
use Noneo\Sdk\Lemlist\Dto\StepPersonalizationDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Leads\AddCustomVariablesOnLeads;
use Noneo\Sdk\Lemlist\Requests\Leads\CreateLeadInCampaign;
use Noneo\Sdk\Lemlist\Requests\Leads\DeleteOrUnsubscribeLead;
use Noneo\Sdk\Lemlist\Requests\Leads\EraseValuesOfCustomVariablesOnALead;
use Noneo\Sdk\Lemlist\Requests\Leads\GetCampaignLeads;
use Noneo\Sdk\Lemlist\Requests\Leads\GetCrmFilters;
use Noneo\Sdk\Lemlist\Requests\Leads\GetLeadByEmail;
use Noneo\Sdk\Lemlist\Requests\Leads\GetLeadByEmailOrId;
use Noneo\Sdk\Lemlist\Requests\Leads\ImportLeadsFromCrm;
use Noneo\Sdk\Lemlist\Requests\Leads\LaunchLead;
use Noneo\Sdk\Lemlist\Requests\Leads\MarkLeadAsInterested;
use Noneo\Sdk\Lemlist\Requests\Leads\MarkLeadAsInterestedInCampaign;
use Noneo\Sdk\Lemlist\Requests\Leads\MarkLeadAsNotInterested;
use Noneo\Sdk\Lemlist\Requests\Leads\MarkLeadAsNotInterestedInCampaign;
use Noneo\Sdk\Lemlist\Requests\Leads\PauseLead;
use Noneo\Sdk\Lemlist\Requests\Leads\PersonalizeStepForLead;
use Noneo\Sdk\Lemlist\Requests\Leads\ResetStepPersonalizationForLead;
use Noneo\Sdk\Lemlist\Requests\Leads\ResumePausedLead;
use Noneo\Sdk\Lemlist\Requests\Leads\UnsubscribeLeadFromCampaign;
use Noneo\Sdk\Lemlist\Requests\Leads\UnsubscribeLeadFromCampaignByEmail;
use Noneo\Sdk\Lemlist\Requests\Leads\UpdateLeadInACampaign;
use Noneo\Sdk\Lemlist\Requests\Leads\UpdateValuesOfCustomVariablesOfALead;
use Noneo\Sdk\Lemlist\Requests\Leads\UploadAudioForVoiceMessageStep;

/**
 * Section « Leads » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Leads
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Get Lead by Email or ID.
     *
     * `GET /leads`
     *
     * @param string|null $id      The lead ID
     * @param string|null $email   The lead email
     * @param string|null $version API version (valeurs : v2)
     *
     * @return array<array-key, mixed>
     */
    public function getLeadByEmailOrId(
        ?string $id = null,
        ?string $email = null,
        ?string $version = null,
    ): array {
        $response = $this->connector->send(new GetLeadByEmailOrId(
            id: $id,
            email: $email,
            version: $version,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Lead by Email.
     *
     * `GET /leads/{email}`
     *
     * @param string      $email   The email address of the lead
     * @param string|null $version API version (valeurs : v2)
     *
     * @return list<LeadV2Dto>
     */
    public function getLeadByEmail(string $email, ?string $version = null): array
    {
        $response = $this->connector->send(new GetLeadByEmail(email: $email, version: $version));

        return array_map(LeadV2Dto::fromArray(...), ResponseDecoder::items($response));
    }

    /**
     * Get Campaign Leads.
     *
     * `GET /campaigns/{campaignId}/leads/`
     *
     * @param string      $campaignId The unique identifier of the campaign
     * @param string|null $state      Filter leads by state (e.g., scanned, contacted, interested, notInterested, etc.)
     * @param int|null    $limit      Maximum number of leads to return
     * @param int|null    $offset     Number of leads to skip, for paging past the first page
     *
     * @return array<array-key, mixed>
     */
    public function getCampaignLeads(
        string $campaignId,
        ?string $state = null,
        ?int $limit = null,
        ?int $offset = null,
    ): array {
        $response = $this->connector->send(new GetCampaignLeads(
            campaignId: $campaignId,
            state: $state,
            limit: $limit,
            offset: $offset,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Create Lead in Campaign.
     *
     * `POST /campaigns/{campaignId}/leads/`
     *
     * @param string               $campaignId         The unique identifier of the campaign
     * @param string|null          $email              Email of the lead
     * @param string|null          $firstName          First name of the lead
     * @param string|null          $lastName           Last name of the lead
     * @param string|null          $companyName        Company name
     * @param string|null          $jobTitle           Job title
     * @param string|null          $linkedinUrl        LinkedIn profile URL
     * @param string|null          $picture            Profile picture URL
     * @param string|null          $phone              Phone number
     * @param string|null          $companyDomain      Company domain
     * @param string|null          $icebreaker         Personalized icebreaker message
     * @param string|null          $timezone           Lead's timezone in IANA format (e.g., Europe/Paris, America/New_York)
     * @param string|null          $contactOwner       Contact owner (user ID or user login email)
     * @param string|null          $crmId              Reserved for this link, never stored as a custom variable
     * @param bool|null            $deduplicate        Refuse the lead with `409 LEAD_ALREADY_IN_OTHER_CAMPAIGN` when the contact already has one in another campaign
     * @param bool|null            $linkedinEnrichment Run the LinkedIn enrichment
     * @param bool|null            $findEmail          Find verified email
     * @param bool|null            $verifyEmail        Verify existing email (debounce)
     * @param bool|null            $findPhone          Find phone number
     * @param string|null          $updateStrategy     What the matched contact and company keep (the lead is always created) (valeurs : overwrite, overwriteIgnoreEmpty, fillEmptyOnly)
     * @param array<string, mixed> $additional         champs supplémentaires, envoyés tels quels (variables personnalisées…)
     *
     * @return array<array-key, mixed>
     */
    public function createLeadInCampaign(
        string $campaignId,
        ?string $email = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $companyName = null,
        ?string $jobTitle = null,
        ?string $linkedinUrl = null,
        ?string $picture = null,
        ?string $phone = null,
        ?string $companyDomain = null,
        ?string $icebreaker = null,
        ?string $timezone = null,
        ?string $contactOwner = null,
        ?string $crmId = null,
        ?bool $deduplicate = null,
        ?bool $linkedinEnrichment = null,
        ?bool $findEmail = null,
        ?bool $verifyEmail = null,
        ?bool $findPhone = null,
        ?string $updateStrategy = null,
        array $additional = [],
    ): array {
        $response = $this->connector->send(new CreateLeadInCampaign(
            campaignId: $campaignId,
            email: $email,
            firstName: $firstName,
            lastName: $lastName,
            companyName: $companyName,
            jobTitle: $jobTitle,
            linkedinUrl: $linkedinUrl,
            picture: $picture,
            phone: $phone,
            companyDomain: $companyDomain,
            icebreaker: $icebreaker,
            timezone: $timezone,
            contactOwner: $contactOwner,
            crmId: $crmId,
            deduplicate: $deduplicate,
            linkedinEnrichment: $linkedinEnrichment,
            findEmail: $findEmail,
            verifyEmail: $verifyEmail,
            findPhone: $findPhone,
            updateStrategy: $updateStrategy,
            additional: $additional,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Unsubscribe Lead from Campaign.
     *
     * `DELETE /campaigns/{campaignId}/leads/`
     *
     * @param string $campaignId The unique identifier of the campaign
     *
     * @return array<array-key, mixed>
     */
    public function unsubscribeLeadFromCampaign(string $campaignId): array
    {
        $response = $this->connector->send(new UnsubscribeLeadFromCampaign(campaignId: $campaignId));

        return ResponseDecoder::object($response);
    }

    /**
     * Update Lead in a Campaign.
     *
     * `PATCH /campaigns/{campaignId}/leads/{leadId}`
     *
     * @param string      $campaignId             The unique identifier of the campaign
     * @param string      $leadId                 The unique identifier of the lead
     * @param string|null $companyName            New name of the company the lead is linked to, renamed in place
     * @param string|null $preferredContactMethod Preferred contact method (email, linkedIn)
     * @param string|null $updateStrategy         What the lead, its contact and its company keep (valeurs : overwrite, overwriteIgnoreEmpty, fillEmptyOnly)
     *
     * @return array<array-key, mixed>
     */
    public function updateLeadInACampaign(
        string $campaignId,
        string $leadId,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $companyName = null,
        ?string $jobTitle = null,
        ?string $preferredContactMethod = null,
        ?string $updateStrategy = null,
    ): array {
        $response = $this->connector->send(new UpdateLeadInACampaign(
            campaignId: $campaignId,
            leadId: $leadId,
            firstName: $firstName,
            lastName: $lastName,
            companyName: $companyName,
            jobTitle: $jobTitle,
            preferredContactMethod: $preferredContactMethod,
            updateStrategy: $updateStrategy,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Delete or Unsubscribe Lead.
     *
     * `DELETE /campaigns/{campaignId}/leads/{leadId}`
     *
     * @param string      $campaignId The unique identifier of the campaign
     * @param string      $leadId     The unique identifier of the lead
     * @param string|null $action     Use 'remove' to force delete
     *
     * @return array<array-key, mixed>
     */
    public function deleteOrUnsubscribeLead(
        string $campaignId,
        string $leadId,
        ?string $action = null,
    ): array {
        $response = $this->connector->send(new DeleteOrUnsubscribeLead(
            campaignId: $campaignId,
            leadId: $leadId,
            action: $action,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Unsubscribe Lead from Campaign.
     *
     * `DELETE /campaigns/{campaignId}/leads/{email}`
     *
     * @param string $campaignId The unique identifier of the campaign
     * @param string $email      The email of the lead
     *
     * @return array<array-key, mixed>
     */
    public function unsubscribeLeadFromCampaignByEmail(string $campaignId, string $email): array
    {
        $response = $this->connector->send(new UnsubscribeLeadFromCampaignByEmail(campaignId: $campaignId, email: $email));

        return ResponseDecoder::object($response);
    }

    /**
     * Resume Paused Lead.
     *
     * `POST /leads/start/{leadId}`
     *
     * @param string $leadId The unique identifier of the lead
     *
     * @return array<array-key, mixed>
     */
    public function resumePausedLead(string $leadId): array
    {
        $response = $this->connector->send(new ResumePausedLead(leadId: $leadId));

        return ResponseDecoder::object($response);
    }

    /**
     * Pause Lead.
     *
     * `POST /leads/pause/{leadId}`
     *
     * @param string      $leadId     The unique identifier of the lead
     * @param string|null $campaignId ID of the campaign
     *
     * @return array<array-key, mixed>
     */
    public function pauseLead(string $leadId, ?string $campaignId = null): array
    {
        $response = $this->connector->send(new PauseLead(leadId: $leadId, campaignId: $campaignId));

        return ResponseDecoder::object($response);
    }

    /**
     * Launch Lead.
     *
     * `POST /leads/review/{leadId}`
     *
     * @param string $leadId The unique identifier of the lead to launch
     *
     * @return array<array-key, mixed>
     */
    public function launchLead(string $leadId): array
    {
        $response = $this->connector->send(new LaunchLead(leadId: $leadId));

        return ResponseDecoder::object($response);
    }

    /**
     * Mark Lead as Interested.
     *
     * `POST /leads/interested/{leadIdOrEmail}`
     *
     * @param string $leadIdOrEmail The unique identifier or email of the lead
     *
     * @return array<array-key, mixed>
     */
    public function markLeadAsInterested(string $leadIdOrEmail): array
    {
        $response = $this->connector->send(new MarkLeadAsInterested(leadIdOrEmail: $leadIdOrEmail));

        return ResponseDecoder::object($response);
    }

    /**
     * Mark Lead as Not Interested.
     *
     * `POST /leads/notinterested/{leadIdOrEmail}`
     *
     * @param string $leadIdOrEmail The unique identifier or email of the lead
     *
     * @return array<array-key, mixed>
     */
    public function markLeadAsNotInterested(string $leadIdOrEmail): array
    {
        $response = $this->connector->send(new MarkLeadAsNotInterested(leadIdOrEmail: $leadIdOrEmail));

        return ResponseDecoder::object($response);
    }

    /**
     * Mark Lead as Interested in Campaign.
     *
     * `POST /campaigns/{campaignId}/leads/{leadIdOrEmail}/interested`
     *
     * @param string $campaignId    The unique identifier of the campaign
     * @param string $leadIdOrEmail The unique identifier or email of the lead
     *
     * @return array<array-key, mixed>
     */
    public function markLeadAsInterestedInCampaign(string $campaignId, string $leadIdOrEmail): array
    {
        $response = $this->connector->send(new MarkLeadAsInterestedInCampaign(campaignId: $campaignId, leadIdOrEmail: $leadIdOrEmail));

        return ResponseDecoder::object($response);
    }

    /**
     * Mark Lead as Not Interested in Campaign.
     *
     * `POST /campaigns/{campaignId}/leads/{leadIdOrEmail}/notinterested`
     *
     * @param string $campaignId    The unique identifier of the campaign
     * @param string $leadIdOrEmail The unique identifier or email of the lead
     *
     * @return array<array-key, mixed>
     */
    public function markLeadAsNotInterestedInCampaign(string $campaignId, string $leadIdOrEmail): array
    {
        $response = $this->connector->send(new MarkLeadAsNotInterestedInCampaign(campaignId: $campaignId, leadIdOrEmail: $leadIdOrEmail));

        return ResponseDecoder::object($response);
    }

    /**
     * Personalize Step for Lead.
     *
     * `PUT /campaigns/{campaignId}/leads/{leadIdOrEmail}/steps/{stepId}/personalization`
     *
     * @param string            $campaignId        The unique identifier of the campaign
     * @param string            $leadIdOrEmail     The unique identifier or email of the lead
     * @param string            $stepId            The unique identifier of the step, from GET /campaigns/{campaignId}/sequences
     * @param string|null       $variant           A/B variant to write on (valeurs : A, B)
     * @param string|null       $subject           Email steps only
     * @param string|null       $message           The message body
     * @param list<string>|null $cc                Email steps only
     * @param bool|null         $plainText         Email steps only
     * @param string|null       $altMessage        LinkedIn invitation and LinkedIn message steps only
     * @param string|null       $altMessagePremium LinkedIn message steps only
     */
    public function personalizeStepForLead(
        string $campaignId,
        string $leadIdOrEmail,
        string $stepId,
        ?string $variant = null,
        ?string $subject = null,
        ?string $message = null,
        ?array $cc = null,
        ?bool $plainText = null,
        ?string $altMessage = null,
        ?string $altMessagePremium = null,
    ): StepPersonalizationDto {
        $response = $this->connector->send(new PersonalizeStepForLead(
            campaignId: $campaignId,
            leadIdOrEmail: $leadIdOrEmail,
            stepId: $stepId,
            variant: $variant,
            subject: $subject,
            message: $message,
            cc: $cc,
            plainText: $plainText,
            altMessage: $altMessage,
            altMessagePremium: $altMessagePremium,
        ));

        return StepPersonalizationDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Reset Step Personalization for Lead.
     *
     * `DELETE /campaigns/{campaignId}/leads/{leadIdOrEmail}/steps/{stepId}/personalization`
     *
     * @param string $campaignId    The unique identifier of the campaign
     * @param string $leadIdOrEmail The unique identifier or email of the lead
     * @param string $stepId        The unique identifier of the step, from GET /campaigns/{campaignId}/sequences
     *
     * @return array<array-key, mixed>
     */
    public function resetStepPersonalizationForLead(
        string $campaignId,
        string $leadIdOrEmail,
        string $stepId,
    ): array {
        $response = $this->connector->send(new ResetStepPersonalizationForLead(
            campaignId: $campaignId,
            leadIdOrEmail: $leadIdOrEmail,
            stepId: $stepId,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Add Custom Variables on Leads.
     *
     * `POST /leads/{leadId}/variables`
     *
     * @param string      $leadId       The unique identifier of the lead
     * @param string|null $customField1 Example custom variable
     * @param string|null $customField2 Example custom variable
     * @param string|null $customField3 Example custom variable
     *
     * @return array<array-key, mixed>
     */
    public function addCustomVariablesOnLeads(
        string $leadId,
        ?string $customField1 = null,
        ?string $customField2 = null,
        ?string $customField3 = null,
    ): array {
        $response = $this->connector->send(new AddCustomVariablesOnLeads(
            leadId: $leadId,
            customField1: $customField1,
            customField2: $customField2,
            customField3: $customField3,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Update Values of Custom Variables of a Lead.
     *
     * `PATCH /leads/{leadId}/variables`
     *
     * @param string      $leadId       The unique identifier of the lead
     * @param string|null $customField1 Example custom variable
     * @param string|null $customField2 Example custom variable
     * @param string|null $customField3 Example custom variable
     *
     * @return array<array-key, mixed>
     */
    public function updateValuesOfCustomVariablesOfALead(
        string $leadId,
        ?string $customField1 = null,
        ?string $customField2 = null,
        ?string $customField3 = null,
    ): array {
        $response = $this->connector->send(new UpdateValuesOfCustomVariablesOfALead(
            leadId: $leadId,
            customField1: $customField1,
            customField2: $customField2,
            customField3: $customField3,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Erase Values of Custom Variables on a Lead.
     *
     * `DELETE /leads/{leadId}/variables`
     *
     * @param string      $leadId       The unique identifier of the lead
     * @param string|null $customField1 Example custom variable
     * @param string|null $customField2 Example custom variable
     * @param string|null $customField3 Example custom variable
     *
     * @return array<array-key, mixed>
     */
    public function eraseValuesOfCustomVariablesOnALead(
        string $leadId,
        ?string $customField1 = null,
        ?string $customField2 = null,
        ?string $customField3 = null,
    ): array {
        $response = $this->connector->send(new EraseValuesOfCustomVariablesOnALead(
            leadId: $leadId,
            customField1: $customField1,
            customField2: $customField2,
            customField3: $customField3,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Upload Audio for Voice Message Step.
     *
     * `POST /leads/audio`
     *
     * @param string $file   chemin du fichier à envoyer
     * @param string $leadId The unique identifier of the lead
     * @param string $stepId The unique identifier of the voice message step
     *
     * @return array<array-key, mixed>
     */
    public function uploadAudioForVoiceMessageStep(
        string $file,
        string $leadId,
        string $stepId,
    ): array {
        $response = $this->connector->send(new UploadAudioForVoiceMessageStep(
            file: $file,
            leadId: $leadId,
            stepId: $stepId,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Get CRM Filters.
     *
     * `GET /crm/filters`
     *
     * @param string|null $type Salesforce only: `lead` or `contact` list views, or `report` (valeurs : lead, contact, report)
     *
     * @return array<array-key, mixed>
     */
    public function getCrmFilters(?string $type = null): array
    {
        $response = $this->connector->send(new GetCrmFilters(type: $type));

        return ResponseDecoder::object($response);
    }

    /**
     * Import Leads from CRM.
     *
     * `POST /campaigns/{campaignId}/leads/import`
     *
     * @param string                   $campaignId    The unique identifier of the campaign
     * @param mixed                    $filterId      Filter ID returned by [Get CRM Filters](/api-reference/endpoints/crm/get-crm-filters)
     * @param string|null              $filterType    Salesforce only: `lead` or `contact` list views, or `report` (valeurs : lead, contact, report)
     * @param string|null              $userId        Salesforce only, for a list view scoped to its owner ("My leads", "My contacts"…): the team member the view is read as
     * @param mixed                    $deduplicate   `all` (or `true`) skips contacts already in another campaign, `activeOnly` skips only contacts still active in another campaign, `off` (or `false`, the default…
     * @param string|list<string>|null $enrichFeature Enrichments to run on every imported lead, as an array or a `|`-separated string (e.g
     *
     * @return array<array-key, mixed>
     */
    public function importLeadsFromCrm(
        string $campaignId,
        mixed $filterId,
        ?string $filterType = null,
        ?string $userId = null,
        mixed $deduplicate = null,
        string|array|null $enrichFeature = null,
    ): array {
        $response = $this->connector->send(new ImportLeadsFromCrm(
            campaignId: $campaignId,
            filterId: $filterId,
            filterType: $filterType,
            userId: $userId,
            deduplicate: $deduplicate,
            enrichFeature: $enrichFeature,
        ));

        return ResponseDecoder::object($response);
    }
}
