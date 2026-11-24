<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Leads;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Add Custom Variables on Leads — `POST /leads/{leadId}/variables`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class AddCustomVariablesOnLeads extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $leadId,
        private readonly ?string $customField1 = null,
        private readonly ?string $customField2 = null,
        private readonly ?string $customField3 = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/leads/'.rawurlencode($this->leadId).'/variables';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'customField1' => $this->customField1,
            'customField2' => $this->customField2,
            'customField3' => $this->customField3,
        ]);
    }
}
