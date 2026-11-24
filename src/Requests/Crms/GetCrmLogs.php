<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Crms;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get CRM Logs — `GET /v2/crm/logs`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class GetCrmLogs extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $contactId = null,
        private readonly ?string $companyId = null,
        private readonly ?int $page = null,
        private readonly ?int $limit = null,
        private readonly ?string $state = null,
        private readonly ?string $category = null,
        private readonly ?string $methodValue = null,
        private readonly ?string $field = null,
        private readonly \DateTimeInterface|string|null $from = null,
        private readonly \DateTimeInterface|string|null $to = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/crm/logs';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return Payload::query([
            'contactId' => $this->contactId,
            'companyId' => $this->companyId,
            'page' => $this->page,
            'limit' => $this->limit,
            'state' => $this->state,
            'category' => $this->category,
            'method' => $this->methodValue,
            'field' => $this->field,
            'from' => $this->from,
            'to' => $this->to,
        ]);
    }
}
