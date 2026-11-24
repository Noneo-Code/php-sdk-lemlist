<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Dto\LabelDto;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Inbox\AttachLabelsToConversations;
use Noneo\Sdk\Lemlist\Requests\Inbox\CreateDraft;
use Noneo\Sdk\Lemlist\Requests\Inbox\CreateLabel;
use Noneo\Sdk\Lemlist\Requests\Inbox\DeleteDraft;
use Noneo\Sdk\Lemlist\Requests\Inbox\GetContactMessages;
use Noneo\Sdk\Lemlist\Requests\Inbox\GetDraft;
use Noneo\Sdk\Lemlist\Requests\Inbox\GetLabel;
use Noneo\Sdk\Lemlist\Requests\Inbox\GetManyInboxes;
use Noneo\Sdk\Lemlist\Requests\Inbox\GetManyLabels;
use Noneo\Sdk\Lemlist\Requests\Inbox\ListDrafts;
use Noneo\Sdk\Lemlist\Requests\Inbox\RemoveLabelsFromConversation;
use Noneo\Sdk\Lemlist\Requests\Inbox\SendEmail;
use Noneo\Sdk\Lemlist\Requests\Inbox\SendLinkedInMessage;
use Noneo\Sdk\Lemlist\Requests\Inbox\SendSmsMessage;
use Noneo\Sdk\Lemlist\Requests\Inbox\SendWhatsAppMessage;
use Noneo\Sdk\Lemlist\Requests\Inbox\UpdateDraft;

/**
 * Section « Inbox » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Inbox
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * Get Many Inboxes.
     *
     * `GET /inbox`
     *
     * @param string   $userId Filter by user ID
     * @param int|null $page   The page number to retrieve
     * @param int|null $limit  The maximum number of records to return
     *
     * @return array<array-key, mixed>
     */
    public function getManyInboxes(
        string $userId,
        ?int $page = null,
        ?int $limit = null,
    ): array {
        $response = $this->connector->send(new GetManyInboxes(
            userId: $userId,
            page: $page,
            limit: $limit,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Contact Messages.
     *
     * `GET /inbox/{contactId}`
     *
     * @param string      $contactId  The unique identifier of the contact
     * @param string|null $userId     ID of the user viewing the conversation
     * @param int|null    $limit      The maximum number of records to return
     * @param int|null    $skip       Number of items to skip
     * @param bool|null   $markAsRead When true, marks the conversation as read
     *
     * @return array<array-key, mixed>
     */
    public function getContactMessages(
        string $contactId,
        ?string $userId = null,
        ?int $limit = null,
        ?int $skip = null,
        ?bool $markAsRead = null,
    ): array {
        $response = $this->connector->send(new GetContactMessages(
            contactId: $contactId,
            userId: $userId,
            limit: $limit,
            skip: $skip,
            markAsRead: $markAsRead,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Send Email.
     *
     * `POST /inbox/email`
     *
     * @param string            $sendUserId        Sender user ID
     * @param string            $sendUserEmail     Sender email address
     * @param string            $sendUserMailboxId Sender mailbox ID
     * @param string            $message           Email message (HTML)
     * @param string|null       $contactId         Contact ID
     * @param string|null       $leadId            Lead ID
     * @param string|null       $subject           Email subject
     * @param list<string>|null $cc                CC email addresses
     * @param string|null       $replyToActivityId Reply within an existing email thread
     *
     * @return array<array-key, mixed>
     */
    public function sendEmail(
        string $sendUserId,
        string $sendUserEmail,
        string $sendUserMailboxId,
        string $message,
        ?string $contactId = null,
        ?string $leadId = null,
        ?string $subject = null,
        ?array $cc = null,
        ?string $replyToActivityId = null,
    ): array {
        $response = $this->connector->send(new SendEmail(
            sendUserId: $sendUserId,
            sendUserEmail: $sendUserEmail,
            sendUserMailboxId: $sendUserMailboxId,
            message: $message,
            contactId: $contactId,
            leadId: $leadId,
            subject: $subject,
            cc: $cc,
            replyToActivityId: $replyToActivityId,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Send LinkedIn Message.
     *
     * `POST /inbox/linkedin`
     *
     * @param string $sendUserId Sender user ID
     * @param string $leadId     Lead ID
     * @param string $contactId  Contact ID
     * @param string $message    Message content
     *
     * @return array<array-key, mixed>
     */
    public function sendLinkedInMessage(
        string $sendUserId,
        string $leadId,
        string $contactId,
        string $message,
    ): array {
        $response = $this->connector->send(new SendLinkedInMessage(
            sendUserId: $sendUserId,
            leadId: $leadId,
            contactId: $contactId,
            message: $message,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Send WhatsApp Message.
     *
     * `POST /inbox/whatsapp`
     *
     * @param string $sendUserId                Sender user ID
     * @param string $sendUserWhatsappAccountId WhatsApp account ID
     * @param string $contactId                 Contact ID
     * @param string $leadId                    Lead ID
     * @param string $message                   Message content
     */
    public function sendWhatsAppMessage(
        string $sendUserId,
        string $sendUserWhatsappAccountId,
        string $contactId,
        string $leadId,
        string $message,
    ): mixed {
        $response = $this->connector->send(new SendWhatsAppMessage(
            sendUserId: $sendUserId,
            sendUserWhatsappAccountId: $sendUserWhatsappAccountId,
            contactId: $contactId,
            leadId: $leadId,
            message: $message,
        ));

        return ResponseDecoder::value($response);
    }

    /**
     * Send SMS Message.
     *
     * `POST /inbox/sms`
     *
     * @param string      $sendUserId Sender user ID
     * @param string      $from       Sender phone number, in E.164 format
     * @param string      $message    SMS body
     * @param string|null $contactId  Contact ID
     * @param string|null $leadId     Lead ID
     *
     * @return array<array-key, mixed>
     */
    public function sendSmsMessage(
        string $sendUserId,
        string $from,
        string $message,
        ?string $contactId = null,
        ?string $leadId = null,
    ): array {
        $response = $this->connector->send(new SendSmsMessage(
            sendUserId: $sendUserId,
            from: $from,
            message: $message,
            contactId: $contactId,
            leadId: $leadId,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Many Labels.
     *
     * `GET /inbox/labels`
     *
     * @return list<LabelDto>
     */
    public function getManyLabels(): array
    {
        $response = $this->connector->send(new GetManyLabels());

        return array_map(LabelDto::fromArray(...), ResponseDecoder::items($response));
    }

    /**
     * Create Label.
     *
     * `POST /inbox/labels`
     *
     * @param string $labelName Name of the label to create
     */
    public function createLabel(string $labelName): LabelDto
    {
        $response = $this->connector->send(new CreateLabel(labelName: $labelName));

        return LabelDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Get Label.
     *
     * `GET /inbox/labels/{labelId}`
     *
     * @param string $labelId Label ID
     */
    public function getLabel(string $labelId): LabelDto
    {
        $response = $this->connector->send(new GetLabel(labelId: $labelId));

        return LabelDto::fromArray(ResponseDecoder::object($response));
    }

    /**
     * Attach Labels to Conversations.
     *
     * `POST /inbox/conversations/labels/{contactId}`
     *
     * @param string       $contactId    Contact ID
     * @param list<string> $labelIds     Array of label IDs to attach
     * @param bool         $appendLabels If true, appends labels to existing ones
     *
     * @return array<array-key, mixed>
     */
    public function attachLabelsToConversations(
        string $contactId,
        array $labelIds,
        bool $appendLabels,
    ): array {
        $response = $this->connector->send(new AttachLabelsToConversations(
            contactId: $contactId,
            labelIds: $labelIds,
            appendLabels: $appendLabels,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Remove Labels from Conversation.
     *
     * `DELETE /inbox/conversations/labels/{contactId}`
     *
     * @param string       $contactId Contact ID
     * @param list<string> $labelIds  Array of label IDs to remove
     *
     * @return array<array-key, mixed>
     */
    public function removeLabelsFromConversation(string $contactId, array $labelIds): array
    {
        $response = $this->connector->send(new RemoveLabelsFromConversation(contactId: $contactId, labelIds: $labelIds));

        return ResponseDecoder::object($response);
    }

    /**
     * List Drafts.
     *
     * `GET /inbox/{contactId}/drafts`
     *
     * @param string $contactId  Contact ID
     * @param string $draftOwner Draft owner identifier
     *
     * @return array<array-key, mixed>
     */
    public function listDrafts(string $contactId, string $draftOwner): array
    {
        $response = $this->connector->send(new ListDrafts(contactId: $contactId, draftOwner: $draftOwner));

        return ResponseDecoder::object($response);
    }

    /**
     * Create Draft.
     *
     * `POST /inbox/{contactId}/drafts`
     *
     * @param string                          $contactId         Contact ID
     * @param string                          $channel           Communication channel (valeurs : email, linkedin, whatsapp, sms)
     * @param string                          $content           Draft content (max 30KB)
     * @param string                          $draftOwner        Draft owner identifier
     * @param string|null                     $subject           Draft subject (optional)
     * @param list<string>|null               $cc                CC email addresses (optional)
     * @param list<array<string, mixed>>|null $attachments       File attachments (optional)
     * @param string|null                     $replyToActivityId Activity ID to reply to (optional)
     * @param array<string, mixed>|null       $sourceMetadata    Additional metadata (optional)
     *
     * @return array<array-key, mixed>
     */
    public function createDraft(
        string $contactId,
        string $channel,
        string $content,
        string $draftOwner,
        ?string $subject = null,
        ?array $cc = null,
        ?array $attachments = null,
        ?string $replyToActivityId = null,
        ?array $sourceMetadata = null,
    ): array {
        $response = $this->connector->send(new CreateDraft(
            contactId: $contactId,
            channel: $channel,
            content: $content,
            draftOwner: $draftOwner,
            subject: $subject,
            cc: $cc,
            attachments: $attachments,
            replyToActivityId: $replyToActivityId,
            sourceMetadata: $sourceMetadata,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Get Draft.
     *
     * `GET /inbox/{contactId}/drafts/{draftId}`
     *
     * @param string $contactId  Contact ID
     * @param string $draftId    Draft ID
     * @param string $draftOwner Draft owner identifier
     *
     * @return array<array-key, mixed>
     */
    public function getDraft(
        string $contactId,
        string $draftId,
        string $draftOwner,
    ): array {
        $response = $this->connector->send(new GetDraft(
            contactId: $contactId,
            draftId: $draftId,
            draftOwner: $draftOwner,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Update Draft.
     *
     * `PATCH /inbox/{contactId}/drafts/{draftId}`
     *
     * @param string                          $contactId         Contact ID
     * @param string                          $draftId           Draft ID
     * @param string                          $draftOwner        Draft owner identifier
     * @param string|null                     $subject           Draft subject
     * @param list<string>|null               $cc                CC email addresses
     * @param string|null                     $content           Draft content (max 30KB)
     * @param list<array<string, mixed>>|null $attachments       File attachments
     * @param string|null                     $replyToActivityId Activity ID to reply to
     *
     * @return array<array-key, mixed>
     */
    public function updateDraft(
        string $contactId,
        string $draftId,
        string $draftOwner,
        ?string $subject = null,
        ?array $cc = null,
        ?string $content = null,
        ?array $attachments = null,
        ?string $replyToActivityId = null,
    ): array {
        $response = $this->connector->send(new UpdateDraft(
            contactId: $contactId,
            draftId: $draftId,
            draftOwner: $draftOwner,
            subject: $subject,
            cc: $cc,
            content: $content,
            attachments: $attachments,
            replyToActivityId: $replyToActivityId,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Delete Draft.
     *
     * `DELETE /inbox/{contactId}/drafts/{draftId}`
     *
     * @param string $contactId  Contact ID
     * @param string $draftId    Draft ID
     * @param string $draftOwner Draft owner identifier
     *
     * @return array<array-key, mixed>
     */
    public function deleteDraft(
        string $contactId,
        string $draftId,
        string $draftOwner,
    ): array {
        $response = $this->connector->send(new DeleteDraft(
            contactId: $contactId,
            draftId: $draftId,
            draftOwner: $draftOwner,
        ));

        return ResponseDecoder::object($response);
    }
}
