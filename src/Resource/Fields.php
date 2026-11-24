<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Resource;

use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Requests\Fields\CreateOrUpdateField;
use Noneo\Sdk\Lemlist\Requests\Fields\DeleteField;
use Noneo\Sdk\Lemlist\Requests\Fields\ListFields;

/**
 * Section « Fields » de l'API lemlist.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 */
final class Fields
{
    /**
     * @internal
     */
    public function __construct(private readonly LemlistConnector $connector)
    {
    }

    /**
     * List Fields.
     *
     * `GET /fields`
     *
     * @param string|null $entity Filter by entity type (valeurs : contact, company)
     * @param string|null $source Filter by field source (valeurs : default, custom, crm_synced)
     *
     * @return array<array-key, mixed>
     */
    public function listFields(?string $entity = null, ?string $source = null): array
    {
        $response = $this->connector->send(new ListFields(entity: $entity, source: $source));

        return ResponseDecoder::object($response);
    }

    /**
     * Create or Update Field.
     *
     * `POST /fields`
     *
     * @param string                    $entity        Entity the field belongs to (valeurs : contact, company)
     * @param string                    $name          Key to write the field with on `POST /contacts` or `POST /companies`
     * @param string                    $type          Field data type (valeurs : text, multilineText, number, date, select, boolean, phone, user, url)
     * @param string|null               $label         Display name of the field, as shown in lemlist
     * @param list<string>|null         $upsertOptions Select fields only
     * @param array<string, mixed>|null $renameOptions Select fields only, on an update: `{ "current value": "new value" }`
     * @param list<string>|null         $removeOptions Select fields only, on an update: options to drop
     * @param array<string, mixed>|null $crmPicklist   Beta
     *
     * @return array<array-key, mixed>
     */
    public function createOrUpdateField(
        string $entity,
        string $name,
        string $type,
        ?string $label = null,
        ?array $upsertOptions = null,
        ?array $renameOptions = null,
        ?array $removeOptions = null,
        ?array $crmPicklist = null,
    ): array {
        $response = $this->connector->send(new CreateOrUpdateField(
            entity: $entity,
            name: $name,
            type: $type,
            label: $label,
            upsertOptions: $upsertOptions,
            renameOptions: $renameOptions,
            removeOptions: $removeOptions,
            crmPicklist: $crmPicklist,
        ));

        return ResponseDecoder::object($response);
    }

    /**
     * Delete Field.
     *
     * `DELETE /fields/{entity}/{name}`
     *
     * @param string $entity Entity the field belongs to (valeurs : contact, company)
     * @param string $name   The field `name`, URL-encoded
     *
     * @return array<array-key, mixed>
     */
    public function deleteField(string $entity, string $name): array
    {
        $response = $this->connector->send(new DeleteField(entity: $entity, name: $name));

        return ResponseDecoder::object($response);
    }
}
