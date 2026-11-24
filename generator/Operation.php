<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Generator;

final readonly class Operation
{
    public const string BODY_NONE = 'none';
    public const string BODY_OBJECT = 'object';
    public const string BODY_LIST = 'list';
    public const string BODY_MULTIPART = 'multipart';

    /**
     * @param string          $resource   nom de la classe de ressource (`Campaigns`)
     * @param string          $name       nom de la classe de requête (`PauseCampaign`)
     * @param list<Parameter> $parameters dans l'ordre de la signature : obligatoires d'abord
     */
    public function __construct(
        public string $method,
        public string $path,
        public string $resource,
        public string $name,
        public string $summary,
        public array $parameters,
        public string $bodyKind,
        public Returns $returns,
    ) {
    }

    public function key(): string
    {
        return $this->method.' '.$this->path;
    }

    /**
     * @return list<Parameter>
     */
    public function parametersIn(string $in): array
    {
        return array_values(array_filter(
            $this->parameters,
            static fn (Parameter $parameter): bool => $in === $parameter->in,
        ));
    }
}
