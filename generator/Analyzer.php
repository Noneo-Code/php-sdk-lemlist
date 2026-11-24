<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Generator;

/**
 * Traduit chaque opération de la spec en un modèle prêt à rendre.
 */
final readonly class Analyzer
{
    private const int MAX_LISTED_ENUM_VALUES = 12;

    public function __construct(
        private Spec $spec,
        private DtoPlanner $dtos,
    ) {
    }

    /**
     * Les noms déjà attribués font foi : un résumé reformulé côté lemlist ne
     * doit pas renommer une méthode publique du SDK. Seule une opération
     * nouvelle reçoit un nom dérivé de son résumé.
     *
     * @param array<string, string> $names `METHODE /chemin` → `Ressource/Requête`
     *
     * @return list<Operation>
     */
    public function operations(array $names): array
    {
        $operations = [];
        $taken = [];

        foreach ($this->spec->operations() as $entry) {
            $key = $entry['method'].' '.$entry['path'];
            $qualified = $names[$key] ?? $this->deriveName($entry['operation'], $key);

            if (isset($taken[$qualified])) {
                throw new GeneratorException(sprintf('« %s » et « %s » produisent le même nom %s : départagez-les dans generator/operations.json.', $taken[$qualified], $key, $qualified));
            }

            $taken[$qualified] = $key;
            $parts = explode('/', $qualified);

            if (2 !== count($parts) || $parts[0] === $parts[1]) {
                throw new GeneratorException(sprintf('Nom invalide pour « %s » : %s (attendu : Ressource/Requête).', $key, $qualified));
            }

            [$parameters, $bodyKind] = $this->parameters($entry['operation'], $entry['pathItem'], $entry['path'], $key);

            $operations[] = new Operation(
                method: $entry['method'],
                path: $entry['path'],
                resource: $parts[0],
                name: $parts[1],
                summary: $this->summary($entry['operation'], $parts[1]),
                parameters: $parameters,
                bodyKind: $bodyKind,
                returns: $this->returns($entry['operation']),
            );
        }

        return $operations;
    }

    private function deriveName(Node $operation, string $key): string
    {
        $tags = $operation->strings('tags');
        $resource = Naming::pascal($tags[0] ?? '');
        $source = '' !== $operation->string('operationId') ? $operation->string('operationId') : $operation->string('summary');
        $name = Naming::pascal($source);

        if ('' === $resource || '' === $name) {
            throw new GeneratorException(sprintf('« %s » n\'a ni tag ni résumé exploitable : nommez-la dans generator/operations.json.', $key));
        }

        return $resource.'/'.$name;
    }

    private function summary(Node $operation, string $fallback): string
    {
        $summary = trim((string) preg_replace('/\s+/', ' ', $operation->string('summary')));
        $summary = str_replace('*/', '* /', '' === $summary ? $fallback : $summary);

        return rtrim($summary, '.');
    }

    /**
     * @return array{list<Parameter>, string}
     */
    private function parameters(Node $operation, Node $pathItem, string $path, string $key): array
    {
        $declared = [];

        foreach ([...$pathItem->list('parameters'), ...$operation->list('parameters')] as $parameter) {
            $parameter = $this->spec->resolve($parameter);
            $declared[$parameter->string('in').':'.$parameter->string('name')] = $parameter;
        }

        $required = [];
        $optional = [];

        preg_match_all('/\{([^}]+)\}/', $path, $placeholders);

        foreach ($placeholders[1] as $name) {
            $description = isset($declared['path:'.$name]) ? $this->describe($declared['path:'.$name], $declared['path:'.$name]->get('schema')) : '';
            $required[] = new Parameter($name, Parameter::PATH, 'string', null, true, $description);
        }

        $bodyKind = Operation::BODY_NONE;
        $additional = [];
        $content = $operation->get('requestBody')->map('content');

        if ([] !== $content) {
            $mediaType = (string) array_key_first($content);
            $schema = $this->spec->resolve($content[$mediaType]->get('schema'));
            $properties = $schema->map('properties');

            if (str_starts_with($mediaType, 'multipart/')) {
                $bodyKind = Operation::BODY_MULTIPART;

                foreach ($properties as $name => $property) {
                    if ('binary' !== $this->spec->resolve($property)->string('format')) {
                        throw new GeneratorException(sprintf('« %s » : champ multipart non binaire « %s », non pris en charge.', $key, $name));
                    }

                    $required[] = new Parameter($name, Parameter::FILE, 'string', null, true, 'chemin du fichier à envoyer');
                }
            } elseif ('array' === $schema->string('type')) {
                $bodyKind = Operation::BODY_LIST;
                $item = $this->itemType($schema->get('items'));
                $required[] = new Parameter('items', Parameter::ITEMS, 'array', 'list<'.$item.'>', true, Naming::description($schema->string('description')));
            } elseif ([] === $properties) {
                throw new GeneratorException(sprintf('« %s » : corps sans propriétés décrites, non pris en charge.', $key));
            } else {
                $bodyKind = Operation::BODY_OBJECT;
                $requiredFields = $schema->strings('required');

                foreach ($properties as $name => $property) {
                    [$type, $docType] = $this->type($property);
                    $isRequired = in_array($name, $requiredFields, true);
                    $built = new Parameter($name, Parameter::BODY, $type, $docType, $isRequired, $this->describe($this->spec->resolve($property), $property));

                    if ($isRequired) {
                        $required[] = $built;
                    } else {
                        $optional[] = $built;
                    }
                }

                if ($schema->has('additionalProperties') && false !== $schema->value('additionalProperties')) {
                    $additional[] = new Parameter('additional', Parameter::ADDITIONAL, 'array', 'array<string, mixed>', false, 'champs supplémentaires, envoyés tels quels (variables personnalisées…)');
                }
            }
        }

        // Le corps passe avant les options de requête : dans une écriture, c'est
        // lui le sujet de l'appel.
        $requiredQuery = [];
        $optionalQuery = [];

        foreach ($declared as $id => $parameter) {
            if (!str_starts_with($id, 'query:')) {
                continue;
            }

            [$type, $docType] = $this->type($parameter->get('schema'));
            $isRequired = true === $parameter->value('required');
            $built = new Parameter($parameter->string('name'), Parameter::QUERY, $type, $docType, $isRequired, $this->describe($parameter, $parameter->get('schema')));

            if ($isRequired) {
                $requiredQuery[] = $built;
            } else {
                $optionalQuery[] = $built;
            }
        }

        $parameters = [...$required, ...$requiredQuery, ...$optional, ...$optionalQuery, ...$additional];
        $seen = [];

        foreach ($parameters as $parameter) {
            if (isset($seen[$parameter->name]) || 'this' === $parameter->name || 1 !== preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $parameter->name)) {
                throw new GeneratorException(sprintf('« %s » : paramètre « %s » en double ou inutilisable en PHP.', $key, $parameter->name));
            }

            $seen[$parameter->name] = true;
        }

        foreach (array_keys($seen) as $name) {
            if (isset($seen[$name.'Value'])) {
                throw new GeneratorException(sprintf('« %s » : les paramètres « %s » et « %sValue » se télescoperaient dans la requête.', $key, $name, $name));
            }
        }

        return [$parameters, $bodyKind];
    }

    /**
     * Type PHP natif et, s'il faut être plus précis, type de docblock.
     *
     * @return array{string, string|null}
     */
    private function type(Node $schema): array
    {
        $schema = $this->spec->resolve($schema);

        switch ($schema->string('type')) {
            case 'integer':
                return ['int', null];
            case 'number':
                return ['float', null];
            case 'boolean':
                return ['bool', null];
            case 'string':
                return 'date-time' === $schema->string('format') ? ['\DateTimeInterface|string', null] : ['string', null];
            case 'array':
                return ['array', 'list<'.$this->itemType($schema->get('items')).'>'];
            case 'object':
                return ['array', 'array<string, mixed>'];
        }

        if ([] !== $schema->map('properties')) {
            return ['array', 'array<string, mixed>'];
        }

        $alternatives = [];

        foreach ([...$schema->list('oneOf'), ...$schema->list('anyOf')] as $alternative) {
            $alternatives[$this->spec->resolve($alternative)->string('type')] = true;
        }

        ksort($alternatives);

        return match (array_keys($alternatives)) {
            ['string'] => ['string', null],
            ['array'] => ['array', 'list<mixed>'],
            ['array', 'string'] => ['string|array', 'string|list<string>'],
            default => ['mixed', null],
        };
    }

    private function itemType(Node $items): string
    {
        $items = $this->spec->resolve($items);

        return match ($items->string('type')) {
            'string' => 'string',
            'integer' => 'int',
            'number' => 'float',
            'boolean' => 'bool',
            'object' => 'array<string, mixed>',
            default => [] !== $items->map('properties') ? 'array<string, mixed>' : 'mixed',
        };
    }

    /**
     * Description d'un paramètre, complétée des valeurs admises quand la spec
     * les énumère.
     */
    private function describe(Node $source, Node $schema): string
    {
        $description = Naming::description($source->string('description'));
        $values = $this->spec->resolve($schema)->strings('enum');

        if ([] === $values || count($values) > self::MAX_LISTED_ENUM_VALUES) {
            return $description;
        }

        $list = str_replace('*/', '* /', 'valeurs : '.implode(', ', $values));

        return '' === $description ? $list : $description.' ('.$list.')';
    }

    private function returns(Node $operation): Returns
    {
        $responses = $operation->map('responses');
        $successes = array_filter(array_keys($responses), static fn (string $code): bool => str_starts_with($code, '2'));
        sort($successes);

        if ([] === $successes) {
            return new Returns(Returns::VALUE);
        }

        $content = $this->spec->resolve($responses[$successes[0]])->map('content');

        // Rien de documenté ne veut pas dire rien de renvoyé : la valeur reçue
        // est rendue telle quelle plutôt que jetée.
        if ([] === $content) {
            return new Returns(Returns::VALUE);
        }

        if (!isset($content['application/json'])) {
            return new Returns(Returns::TEXT);
        }

        // JSON ou CSV selon un paramètre `format` : seule la valeur telle
        // quelle — décodée si c'est du JSON, brute sinon — tient les deux cas.
        if (count($content) > 1) {
            return new Returns(Returns::VALUE);
        }

        $schema = $content['application/json']->get('schema');

        if ($schema->isEmpty()) {
            return new Returns(Returns::VALUE);
        }

        $reference = Spec::referenceName($schema);

        if (null !== $reference) {
            $dto = $this->dtos->forSchema($reference);

            if (null !== $dto) {
                return new Returns(Returns::DTO, $dto);
            }
        }

        $schema = $this->spec->resolve($schema);

        if ('array' === $schema->string('type')) {
            $itemReference = Spec::referenceName($schema->get('items'));
            $dto = null !== $itemReference ? $this->dtos->forSchema($itemReference) : null;

            return null !== $dto ? new Returns(Returns::DTOS, $dto) : new Returns(Returns::DECODED);
        }

        if (Spec::isObject($schema) || [] !== $schema->list('oneOf') || [] !== $schema->list('anyOf')) {
            return new Returns(Returns::DECODED);
        }

        return new Returns(Returns::VALUE);
    }
}
