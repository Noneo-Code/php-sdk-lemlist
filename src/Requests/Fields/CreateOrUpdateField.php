<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Fields;

use Noneo\Sdk\Lemlist\Support\Payload;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create or Update Field — `POST /fields`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class CreateOrUpdateField extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param list<string>|null         $upsertOptions
     * @param array<string, mixed>|null $renameOptions
     * @param list<string>|null         $removeOptions
     * @param array<string, mixed>|null $crmPicklist
     */
    public function __construct(
        private readonly string $entity,
        private readonly string $name,
        private readonly string $type,
        private readonly ?string $label = null,
        private readonly ?array $upsertOptions = null,
        private readonly ?array $renameOptions = null,
        private readonly ?array $removeOptions = null,
        private readonly ?array $crmPicklist = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/fields';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return Payload::body([
            'entity' => $this->entity,
            'name' => $this->name,
            'type' => $this->type,
            'label' => $this->label,
            'upsertOptions' => $this->upsertOptions,
            'renameOptions' => $this->renameOptions,
            'removeOptions' => $this->removeOptions,
            'crmPicklist' => $this->crmPicklist,
        ]);
    }
}
