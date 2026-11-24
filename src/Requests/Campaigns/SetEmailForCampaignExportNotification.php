<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Campaigns;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Set Email for Campaign Export Notification — `PUT /campaigns/{campaignId}/export/{exportId}/email/{email}`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class SetEmailForCampaignExportNotification extends Request
{
    protected Method $method = Method::PUT;

    public function __construct(
        private readonly string $campaignId,
        private readonly string $exportId,
        private readonly string $email,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns/'.rawurlencode($this->campaignId).'/export/'.rawurlencode($this->exportId).'/email/'.rawurlencode($this->email);
    }
}
