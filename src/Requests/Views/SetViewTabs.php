<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Views;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Set View Tabs — `PUT /views/tabs`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class SetViewTabs extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    /**
     * @param list<string> $pinned
     */
    public function __construct(
        private readonly string $entity,
        private readonly array $pinned,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/views/tabs';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'entity' => $this->entity,
            'pinned' => $this->pinned,
        ]);
    }
}
