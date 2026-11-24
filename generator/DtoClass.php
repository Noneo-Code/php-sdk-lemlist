<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Generator;

final readonly class DtoClass
{
    /**
     * @param string            $origin     schéma nommé (`Campaign`) ou chemin d'un objet imbriqué (`Campaign.senders`)
     * @param list<DtoProperty> $properties
     */
    public function __construct(
        public string $name,
        public string $origin,
        public array $properties,
    ) {
    }
}
