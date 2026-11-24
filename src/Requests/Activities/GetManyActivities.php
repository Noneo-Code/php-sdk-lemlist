<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Activities;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get Many Activities — `GET /activities`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetManyActivities extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $version,
        private readonly ?string $type = null,
        private readonly ?string $campaignId = null,
        private readonly ?bool $isFirst = null,
        private readonly ?int $offset = null,
        private readonly ?int $limit = null,
        private readonly ?string $leadId = null,
        private readonly ?string $minDate = null,
        private readonly ?string $maxDate = null,
        private readonly ?string $startDate = null,
        private readonly ?string $endDate = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/activities';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'version' => $this->version,
            'type' => $this->type,
            'campaignId' => $this->campaignId,
            'isFirst' => $this->isFirst,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'leadId' => $this->leadId,
            'minDate' => $this->minDate,
            'maxDate' => $this->maxDate,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);
    }
}
