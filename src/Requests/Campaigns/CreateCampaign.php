<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Campaigns;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create Campaign — `POST /campaigns`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class CreateCampaign extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string>|null $autoReviewConditions
     */
    public function __construct(
        private readonly string $name,
        private readonly ?string $timezone = null,
        private readonly ?string $emoji = null,
        private readonly ?bool $autoReview = null,
        private readonly ?array $autoReviewConditions = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/campaigns';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'timezone' => $this->timezone,
            'emoji' => $this->emoji,
            'autoReview' => $this->autoReview,
            'autoReviewConditions' => $this->autoReviewConditions,
        ]);
    }
}
