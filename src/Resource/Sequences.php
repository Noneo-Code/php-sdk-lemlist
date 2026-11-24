<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\ConditionBranchDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Sequences\AddConditionBranch;
use Noneo\Sdk\Lemlist\Requests\Sequences\AddStepToSequence;
use Noneo\Sdk\Lemlist\Requests\Sequences\CreateABTestVariant;
use Noneo\Sdk\Lemlist\Requests\Sequences\DeleteABTestVariant;
use Noneo\Sdk\Lemlist\Requests\Sequences\DeleteConditionBranch;
use Noneo\Sdk\Lemlist\Requests\Sequences\DeleteSequenceStep;
use Noneo\Sdk\Lemlist\Requests\Sequences\GetABTestVariant;
use Noneo\Sdk\Lemlist\Requests\Sequences\GetCampaignSequences;
use Noneo\Sdk\Lemlist\Requests\Sequences\GetStepSender;
use Noneo\Sdk\Lemlist\Requests\Sequences\ListConditionBranches;
use Noneo\Sdk\Lemlist\Requests\Sequences\RemoveStepSender;
use Noneo\Sdk\Lemlist\Requests\Sequences\ReorderConditionBranches;
use Noneo\Sdk\Lemlist\Requests\Sequences\SelectABTestWinner;
use Noneo\Sdk\Lemlist\Requests\Sequences\SetStepSender;
use Noneo\Sdk\Lemlist\Requests\Sequences\UpdateABTestVariant;
use Noneo\Sdk\Lemlist\Requests\Sequences\UpdateConditionBranch;
use Noneo\Sdk\Lemlist\Requests\Sequences\UpdateSequenceStep;

/**
 * Section « Sequences » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Sequences
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Get Campaign Sequences.
     *
     * `GET /campaigns/{campaignId}/sequences`
     *
     * @param string $campaignId The unique identifier of the campaign
     *
     * @return array<array-key, mixed>
     */
    public function getCampaignSequences(string $campaignId): array
    {
        $response = $this->connector->send(new GetCampaignSequences(campaignId: $campaignId));

        return ResponseDecoder::object($response);
    }

    /**
     * Add Step to Sequence.
     *
     * `POST /sequences/{sequenceId}/steps`
     *
     * @param string            $sequenceId         The unique identifier of the sequence
     * @param string|null       $type               The type of step to create
     * @param int|null          $index              The position within the sequence to insert the new step (≥ -1)
     * @param int|null          $delay              Delay in days before executing this step
     * @param string|null       $subject            Email subject line (for email steps)
     * @param string|null       $message            Content of the email or message (used for email, linkedinInvite, linkedinSend, linkedinInMail, manual, phone, whatsappMessage, sms steps, and as the AI script…
     * @param string|null       $altMessage         The LinkedIn note sent instead of `message` in specific cases, with a meaning that depends on the step type
     * @param string|null       $altMessagePremium  For `linkedinSend` steps only
     * @param string|null       $customName         The step's own name, shown instead of its type label ("Email", "Call") wherever the app names the step
     * @param string|null       $title              Title of the task the step creates
     * @param bool|null         $manual             Holds a channel step behind a task: `true` creates a task, named by `title` and ranked by `priority`, and the campaign sends the step once the task is marked d…
     * @param int|null          $priority           Priority of the task the step creates: `0` low, `1` medium, `2` high (valeurs : 0, 1, 2)
     * @param string|null       $method             HTTP method for API steps (valeurs : GET, POST, PUT, DELETE, PATCH)
     * @param string|null       $url                URL of the API endpoint to call (required for api steps)
     * @param string|null       $conditionKey       Condition key for conditional steps
     * @param string|null       $delayType          Delay type for conditional steps (valeurs : within, waitUntil)
     * @param string|null       $customField        For conditional steps keyed `customLeadInfo` only
     * @param string|null       $customOperator     For conditional steps keyed `customLeadInfo` only (valeurs : equal, contains, empty, notEmpty)
     * @param string|null       $customValue        For conditional steps keyed `customLeadInfo` only
     * @param string|null       $campaignId         Target campaign ID for sendToAnotherCampaign steps
     * @param string|null       $leadAction         Applies to `sendToAnotherCampaign` steps only (valeurs : continue, pause, stop)
     * @param string|null       $endLeadStatus      Applies to `endSequence` steps only (valeurs : completed, interested, notInterested)
     * @param list<string>|null $images             Public HTTPS URLs of images to attach to a `linkedinInvite` or `linkedinSend` step
     * @param list<string>|null $videos             Public HTTPS URLs of videos to attach to a `linkedinInvite` or `linkedinSend` step
     * @param string|null       $skillName          Name of the LinkedIn skill to endorse on the lead's profile
     * @param bool|null         $endorseAnyFallback Applies to `linkedinEndorse` steps only
     * @param string|null       $recordMode         Applies to `linkedinVoiceNote` steps only (valeurs : manual, ai)
     * @param list<string>|null $workflowIds        Required on `enrichment` steps, with at least one value
     *
     * @return array<array-key, mixed>
     */
    public function addStepToSequence(
        string $sequenceId,
        ?string $type = null,
        ?int $index = null,
        ?int $delay = null,
        ?string $subject = null,
        ?string $message = null,
        ?string $altMessage = null,
        ?string $altMessagePremium = null,
        ?string $customName = null,
        ?string $title = null,
        ?bool $manual = null,
        ?int $priority = null,
        ?string $method = null,
        ?string $url = null,
        ?string $conditionKey = null,
        ?string $delayType = null,
        ?string $customField = null,
        ?string $customOperator = null,
        ?string $customValue = null,
        ?string $campaignId = null,
        ?string $leadAction = null,
        ?string $endLeadStatus = null,
        ?array $images = null,
        ?array $videos = null,
        ?string $skillName = null,
        ?bool $endorseAnyFallback = null,
        ?string $recordMode = null,
        ?array $workflowIds = null,
    ): array {
        $response = $this->connector->send(new AddStepToSequence(
            sequenceId: $sequenceId,
            type: $type,
            index: $index,
            delayValue: $delay,
            subject: $subject,
            message: $message,
            altMessage: $altMessage,
            altMessagePremium: $altMessagePremium,
            customName: $customName,
            title: $title,
            manual: $manual,
            priority: $priority,
            methodValue: $method,
            url: $url,
            conditionKey: $conditionKey,
            delayType: $delayType,
            customField: $customField,
            customOperator: $customOperator,
            customValue: $customValue,
            campaignId: $campaignId,
            leadAction: $leadAction,
            endLeadStatus: $endLeadStatus,
            images: $images,
            videos: $videos,
            skillName: $skillName,
            endorseAnyFallback: $endorseAnyFallback,
            recordMode: $recordMode,
            workflowIds: $workflowIds,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Update Sequence Step.
     *
     * `PATCH /sequences/{sequenceId}/steps/{stepId}`
     *
     * @param string            $sequenceId         The unique identifier of the sequence
     * @param string            $stepId             The unique identifier of the step
     * @param string            $type               The type of step (required but cannot be changed - must match the existing step type)
     * @param int|null          $delay              Delay in days before executing this step
     * @param string|null       $subject            Email subject line (for email steps)
     * @param string|null       $message            Content of the email or message (for email, linkedinInvite, linkedinSend, linkedinInMail, manual, phone, whatsappMessage, sms steps, and as the AI script of a…
     * @param string|null       $altMessage         The LinkedIn note sent instead of `message` in specific cases, with a meaning that depends on the step type
     * @param string|null       $altMessagePremium  For `linkedinSend` steps only
     * @param string|null       $customName         The step's own name, shown instead of its type label ("Email", "Call") wherever the app names the step
     * @param string|null       $title              Title of the task the step creates, on `manual` and `phone` steps and on a channel step with `manual: true`
     * @param bool|null         $manual             `true` holds a channel step behind a task: the campaign sends the step once the task is marked done
     * @param int|null          $priority           Priority of the task the step creates: `0` low, `1` medium, `2` high (valeurs : 0, 1, 2)
     * @param string|null       $method             HTTP method for API steps (valeurs : GET, POST, PUT, DELETE, PATCH)
     * @param string|null       $url                URL of the API endpoint to call (for api steps)
     * @param string|null       $conditionKey       Condition key for conditional steps
     * @param string|null       $delayType          Delay type for conditional steps (valeurs : within, waitUntil)
     * @param string|null       $customField        For conditional steps keyed `customLeadInfo` only
     * @param string|null       $customOperator     For conditional steps keyed `customLeadInfo` only (valeurs : equal, contains, empty, notEmpty)
     * @param string|null       $customValue        For conditional steps keyed `customLeadInfo` only
     * @param string|null       $campaignId         Target campaign ID for sendToAnotherCampaign steps
     * @param string|null       $leadAction         Applies to `sendToAnotherCampaign` steps only (valeurs : continue, pause, stop)
     * @param string|null       $endLeadStatus      Applies to `endSequence` steps only (valeurs : completed, interested, notInterested)
     * @param list<string>|null $images             Public HTTPS URLs of images to attach to a `linkedinInvite` or `linkedinSend` step
     * @param list<string>|null $videos             Public HTTPS URLs of videos to attach to a `linkedinInvite` or `linkedinSend` step
     * @param string|null       $skillName          Name of the LinkedIn skill to endorse on the lead's profile
     * @param bool|null         $endorseAnyFallback Applies to `linkedinEndorse` steps only
     * @param string|null       $recordMode         Applies to `linkedinVoiceNote` steps only (valeurs : manual, ai)
     *
     * @return array<array-key, mixed>
     */
    public function updateSequenceStep(
        string $sequenceId,
        string $stepId,
        string $type,
        ?int $delay = null,
        ?string $subject = null,
        ?string $message = null,
        ?string $altMessage = null,
        ?string $altMessagePremium = null,
        ?string $customName = null,
        ?string $title = null,
        ?bool $manual = null,
        ?int $priority = null,
        ?string $method = null,
        ?string $url = null,
        ?string $conditionKey = null,
        ?string $delayType = null,
        ?string $customField = null,
        ?string $customOperator = null,
        ?string $customValue = null,
        ?string $campaignId = null,
        ?string $leadAction = null,
        ?string $endLeadStatus = null,
        ?array $images = null,
        ?array $videos = null,
        ?string $skillName = null,
        ?bool $endorseAnyFallback = null,
        ?string $recordMode = null,
    ): array {
        $response = $this->connector->send(new UpdateSequenceStep(
            sequenceId: $sequenceId,
            stepId: $stepId,
            type: $type,
            delayValue: $delay,
            subject: $subject,
            message: $message,
            altMessage: $altMessage,
            altMessagePremium: $altMessagePremium,
            customName: $customName,
            title: $title,
            manual: $manual,
            priority: $priority,
            methodValue: $method,
            url: $url,
            conditionKey: $conditionKey,
            delayType: $delayType,
            customField: $customField,
            customOperator: $customOperator,
            customValue: $customValue,
            campaignId: $campaignId,
            leadAction: $leadAction,
            endLeadStatus: $endLeadStatus,
            images: $images,
            videos: $videos,
            skillName: $skillName,
            endorseAnyFallback: $endorseAnyFallback,
            recordMode: $recordMode,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Delete Sequence Step.
     *
     * `DELETE /sequences/{sequenceId}/steps/{stepId}`
     *
     * @param string $sequenceId The unique identifier of the sequence
     * @param string $stepId     The unique identifier of the step
     *
     * @return array<array-key, mixed>
     */
    public function deleteSequenceStep(string $sequenceId, string $stepId): array
    {
        $response = $this->connector->send(new DeleteSequenceStep(sequenceId: $sequenceId, stepId: $stepId));

        return ResponseDecoder::object($response);
    }

    /**
     * List Condition Branches.
     *
     * `GET /sequences/{sequenceId}/steps/{stepId}/branches`
     *
     * @param string $sequenceId The unique identifier of the sequence holding the condition step
     * @param string $stepId     The unique identifier of the condition step, from `GET /campaigns/{campaignId}/sequences`
     *
     * @return list<ConditionBranchDto>
     */
    public function listConditionBranches(string $sequenceId, string $stepId): array
    {
        $response = $this->connector->send(new ListConditionBranches(sequenceId: $sequenceId, stepId: $stepId));

        return array_map(ConditionBranchDto::fromArray(...), ResponseDecoder::items($response));
    }

    /**
     * Add Condition Branch.
     *
     * `POST /sequences/{sequenceId}/steps/{stepId}/branches`
     *
     * @param string            $sequenceId        The unique identifier of the sequence holding the condition step
     * @param string            $stepId            The unique identifier of the condition step, from `GET /campaigns/{campaignId}/sequences`
     * @param string|null       $name              The branch's display name
     * @param string|null       $delayType         How a lead-action condition waits: `within` branches once the `delay` window is over, `waitUntil` parks the lead until the action happens, with no time bound (valeurs : within, waitUntil)
     * @param int|null          $delay             Length of that time window, in days
     * @param string|null       $scoreComparator   `hasScore` only - how the lead's score is compared to `scoreThreshold` (valeurs : $gte, $lt)
     * @param int|null          $scoreThreshold    `hasScore` only - the score this branch tests against
     * @param list<string>|null $emailStatusFilter `hasEmailAddress` only - the email statuses this branch matches
     * @param list<string>|null $callStatusFilter  `aircallDone` only - the call-status keys this branch matches
     * @param string|null       $customField       `customLeadInfo` only - the field to test
     * @param string|null       $customOperator    `customLeadInfo` only - how the field is compared (valeurs : equal, contains, empty, notEmpty)
     * @param string|null       $customValue       `customLeadInfo` only - the value the field is compared to
     */
    public function addConditionBranch(
        string $sequenceId,
        string $stepId,
        ?string $name = null,
        ?string $delayType = null,
        ?int $delay = null,
        ?string $scoreComparator = null,
        ?int $scoreThreshold = null,
        ?array $emailStatusFilter = null,
        ?array $callStatusFilter = null,
        ?string $customField = null,
        ?string $customOperator = null,
        ?string $customValue = null,
    ): ConditionBranchDto {
        $response = $this->connector->send(new AddConditionBranch(
            sequenceId: $sequenceId,
            stepId: $stepId,
            name: $name,
            delayType: $delayType,
            delayValue: $delay,
            scoreComparator: $scoreComparator,
            scoreThreshold: $scoreThreshold,
            emailStatusFilter: $emailStatusFilter,
            callStatusFilter: $callStatusFilter,
            customField: $customField,
            customOperator: $customOperator,
            customValue: $customValue,
        ));

        return ConditionBranchDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Reorder Condition Branches.
     *
     * `PATCH /sequences/{sequenceId}/steps/{stepId}/branches`
     *
     * @param string       $sequenceId The unique identifier of the sequence holding the condition step
     * @param string       $stepId     The unique identifier of the condition step, from `GET /campaigns/{campaignId}/sequences`
     * @param list<string> $order      Every branch of the step by `sequenceId`, in the new execution order, excluding the Else branch
     *
     * @return list<ConditionBranchDto>
     */
    public function reorderConditionBranches(
        string $sequenceId,
        string $stepId,
        array $order,
    ): array {
        $response = $this->connector->send(new ReorderConditionBranches(
            sequenceId: $sequenceId,
            stepId: $stepId,
            order: $order,
        ));

        return array_map(ConditionBranchDto::fromArray(...), ResponseDecoder::items($response));
    }

    /**
     * Update Condition Branch.
     *
     * `PATCH /sequences/{sequenceId}/steps/{stepId}/branches/{branchSequenceId}`
     *
     * @param string            $sequenceId        The unique identifier of the sequence holding the condition step
     * @param string            $stepId            The unique identifier of the condition step, from `GET /campaigns/{campaignId}/sequences`
     * @param string            $branchSequenceId  The branch's own sub-sequence id, from `GET /sequences/{sequenceId}/steps/{stepId}/branches`
     * @param string|null       $name              The branch's display name
     * @param string|null       $delayType         How a lead-action condition waits: `within` branches once the `delay` window is over, `waitUntil` parks the lead until the action happens, with no time bound (valeurs : within, waitUntil)
     * @param int|null          $delay             Length of that time window, in days
     * @param string|null       $scoreComparator   `hasScore` only - how the lead's score is compared to `scoreThreshold` (valeurs : $gte, $lt)
     * @param int|null          $scoreThreshold    `hasScore` only - the score this branch tests against
     * @param list<string>|null $emailStatusFilter `hasEmailAddress` only - the email statuses this branch matches
     * @param list<string>|null $callStatusFilter  `aircallDone` only - the call-status keys this branch matches
     * @param string|null       $customField       `customLeadInfo` only - the field to test
     * @param string|null       $customOperator    `customLeadInfo` only - how the field is compared (valeurs : equal, contains, empty, notEmpty)
     * @param string|null       $customValue       `customLeadInfo` only - the value the field is compared to
     */
    public function updateConditionBranch(
        string $sequenceId,
        string $stepId,
        string $branchSequenceId,
        ?string $name = null,
        ?string $delayType = null,
        ?int $delay = null,
        ?string $scoreComparator = null,
        ?int $scoreThreshold = null,
        ?array $emailStatusFilter = null,
        ?array $callStatusFilter = null,
        ?string $customField = null,
        ?string $customOperator = null,
        ?string $customValue = null,
    ): ConditionBranchDto {
        $response = $this->connector->send(new UpdateConditionBranch(
            sequenceId: $sequenceId,
            stepId: $stepId,
            branchSequenceId: $branchSequenceId,
            name: $name,
            delayType: $delayType,
            delayValue: $delay,
            scoreComparator: $scoreComparator,
            scoreThreshold: $scoreThreshold,
            emailStatusFilter: $emailStatusFilter,
            callStatusFilter: $callStatusFilter,
            customField: $customField,
            customOperator: $customOperator,
            customValue: $customValue,
        ));

        return ConditionBranchDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Delete Condition Branch.
     *
     * `DELETE /sequences/{sequenceId}/steps/{stepId}/branches/{branchSequenceId}`
     *
     * @param string $sequenceId       The unique identifier of the sequence holding the condition step
     * @param string $stepId           The unique identifier of the condition step, from `GET /campaigns/{campaignId}/sequences`
     * @param string $branchSequenceId The branch's own sub-sequence id, from `GET /sequences/{sequenceId}/steps/{stepId}/branches`
     *
     * @return array<array-key, mixed>
     */
    public function deleteConditionBranch(
        string $sequenceId,
        string $stepId,
        string $branchSequenceId,
    ): array {
        $response = $this->connector->send(new DeleteConditionBranch(
            sequenceId: $sequenceId,
            stepId: $stepId,
            branchSequenceId: $branchSequenceId,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Step Sender.
     *
     * `GET /sequences/{sequenceId}/steps/{stepId}/sender`
     *
     * @param string $sequenceId The unique identifier of the sequence
     * @param string $stepId     The unique identifier of the step
     *
     * @return array<array-key, mixed>
     */
    public function getStepSender(string $sequenceId, string $stepId): array
    {
        $response = $this->connector->send(new GetStepSender(sequenceId: $sequenceId, stepId: $stepId));

        return ResponseDecoder::object($response);
    }

    /**
     * Set Step Sender.
     *
     * `PUT /sequences/{sequenceId}/steps/{stepId}/sender`
     *
     * @param string                    $sequenceId The unique identifier of the sequence
     * @param string                    $stepId     The unique identifier of the step
     * @param string                    $userId     The team member who sends the step
     * @param array<string, mixed>|null $channel    Required on an email, LinkedIn, WhatsApp or SMS step
     *
     * @return array<array-key, mixed>
     */
    public function setStepSender(
        string $sequenceId,
        string $stepId,
        string $userId,
        ?array $channel = null,
    ): array {
        $response = $this->connector->send(new SetStepSender(
            sequenceId: $sequenceId,
            stepId: $stepId,
            userId: $userId,
            channel: $channel,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Remove Step Sender.
     *
     * `DELETE /sequences/{sequenceId}/steps/{stepId}/sender`
     *
     * @param string $sequenceId The unique identifier of the sequence
     * @param string $stepId     The unique identifier of the step
     *
     * @return array<array-key, mixed>
     */
    public function removeStepSender(string $sequenceId, string $stepId): array
    {
        $response = $this->connector->send(new RemoveStepSender(sequenceId: $sequenceId, stepId: $stepId));

        return ResponseDecoder::object($response);
    }

    /**
     * Get A/B Test Variant.
     *
     * `GET /sequences/{sequenceId}/steps/{stepId}/ab-test`
     *
     * @param string $sequenceId The unique identifier of the sequence
     * @param string $stepId     The unique identifier of the step
     *
     * @return array<array-key, mixed>
     */
    public function getABTestVariant(string $sequenceId, string $stepId): array
    {
        $response = $this->connector->send(new GetABTestVariant(sequenceId: $sequenceId, stepId: $stepId));

        return ResponseDecoder::object($response);
    }

    /**
     * Create A/B Test Variant.
     *
     * `POST /sequences/{sequenceId}/steps/{stepId}/ab-test`
     *
     * @param string $sequenceId The unique identifier of the sequence
     * @param string $stepId     The unique identifier of the step
     *
     * @return array<array-key, mixed>
     */
    public function createABTestVariant(string $sequenceId, string $stepId): array
    {
        $response = $this->connector->send(new CreateABTestVariant(sequenceId: $sequenceId, stepId: $stepId));

        return ResponseDecoder::object($response);
    }

    /**
     * Update A/B Test Variant.
     *
     * `PATCH /sequences/{sequenceId}/steps/{stepId}/ab-test`
     *
     * @param string            $sequenceId        The unique identifier of the sequence
     * @param string            $stepId            The unique identifier of the step
     * @param string|null       $subject           Variant B subject
     * @param string|null       $message           Variant B body (HTML)
     * @param string|null       $altMessage        Variant B's LinkedIn note, same meaning as the step-level `altMessage`: the premium invitation note on a `linkedinInvite` step, the out-of-network note on a `l…
     * @param string|null       $altMessagePremium Variant B's premium variant of the out-of-network note, on `linkedinSend` steps only: any other step type is rejected with `400`
     * @param list<string>|null $cc
     *
     * @return array<array-key, mixed>
     */
    public function updateABTestVariant(
        string $sequenceId,
        string $stepId,
        ?string $subject = null,
        ?string $message = null,
        ?string $altMessage = null,
        ?string $altMessagePremium = null,
        ?array $cc = null,
        ?bool $plainText = null,
    ): array {
        $response = $this->connector->send(new UpdateABTestVariant(
            sequenceId: $sequenceId,
            stepId: $stepId,
            subject: $subject,
            message: $message,
            altMessage: $altMessage,
            altMessagePremium: $altMessagePremium,
            cc: $cc,
            plainText: $plainText,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Delete A/B Test Variant.
     *
     * `DELETE /sequences/{sequenceId}/steps/{stepId}/ab-test`
     *
     * @param string      $sequenceId The unique identifier of the sequence
     * @param string      $stepId     The unique identifier of the step
     * @param string|null $variant    Which variant to delete (valeurs : A, B)
     *
     * @return array<array-key, mixed>
     */
    public function deleteABTestVariant(
        string $sequenceId,
        string $stepId,
        ?string $variant = null,
    ): array {
        $response = $this->connector->send(new DeleteABTestVariant(
            sequenceId: $sequenceId,
            stepId: $stepId,
            variant: $variant,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Select A/B Test Winner.
     *
     * `POST /sequences/{sequenceId}/steps/{stepId}/ab-test/winner`
     *
     * @param string $sequenceId The unique identifier of the sequence
     * @param string $stepId     The unique identifier of the step
     * @param string $variant    The winning variant (valeurs : A, B)
     *
     * @return array<array-key, mixed>
     */
    public function selectABTestWinner(
        string $sequenceId,
        string $stepId,
        string $variant,
    ): array {
        $response = $this->connector->send(new SelectABTestWinner(
            sequenceId: $sequenceId,
            stepId: $stepId,
            variant: $variant,
        ));

        return ResponseDecoder::object($response);
    }
}
