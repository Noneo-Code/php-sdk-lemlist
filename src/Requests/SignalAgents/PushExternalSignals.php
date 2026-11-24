<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\SignalAgents;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Push external signals — `POST /watchlist/{watchListId}/external-signals`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class PushExternalSignals extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param array<string, mixed>|null $contact
     * @param array<string, mixed>|null $company
     * @param array<string, mixed>|null $customFields
     */
    public function __construct(
        private readonly string $watchListId,
        private readonly ?array $contact = null,
        private readonly ?array $company = null,
        private readonly ?array $customFields = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/watchlist/'.rawurlencode($this->watchListId).'/external-signals';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'contact' => $this->contact,
            'company' => $this->company,
            'customFields' => $this->customFields,
        ]);
    }
}
