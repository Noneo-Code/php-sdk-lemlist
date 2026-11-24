<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Generator;

/**
 * Rend le modèle en fichiers PHP, au format attendu par PHP-CS-Fixer
 * (`@Symfony`).
 */
final class Renderer
{
    private const string ROOT = 'Noneo\\Sdk\\Lemlist';

    private const string NOTICE = 'Fichier généré par `composer generate` : toute modification manuelle sera écrasée.';

    /**
     * Propriétés déjà déclarées par Saloon sur une requête (`$method`,
     * `$body`…) : un paramètre de la spec qui porte l'un de ces noms ne peut
     * pas être promu tel quel.
     *
     * @var list<string>
     */
    private readonly array $reservedProperties;

    public function __construct()
    {
        $reserved = [];

        foreach ([\Saloon\Http\Request::class, \Saloon\Traits\Body\HasJsonBody::class, \Saloon\Traits\Body\HasMultipartBody::class] as $class) {
            foreach ((new \ReflectionClass($class))->getProperties() as $property) {
                $reserved[] = $property->getName();
            }
        }

        $this->reservedProperties = array_values(array_unique($reserved));
    }

    public function request(Operation $operation): string
    {
        $imports = ['Saloon\\Enums\\Method', 'Saloon\\Http\\Request'];
        $implements = '';
        $traits = '';
        $query = $operation->parametersIn(Parameter::QUERY);

        if (Operation::BODY_NONE !== $operation->bodyKind) {
            $imports[] = 'Saloon\\Contracts\\Body\\HasBody';
            $implements = ' implements HasBody';
            $trait = Operation::BODY_MULTIPART === $operation->bodyKind ? 'HasMultipartBody' : 'HasJsonBody';
            $imports[] = 'Saloon\\Traits\\Body\\'.$trait;
            $traits = "    use {$trait};\n\n";
        }

        if (Operation::BODY_MULTIPART === $operation->bodyKind) {
            $imports[] = 'Saloon\\Data\\MultipartValue';
        }

        if ([] !== $query || in_array($operation->bodyKind, [Operation::BODY_OBJECT, Operation::BODY_MULTIPART], true)) {
            $imports[] = self::ROOT.'\\Support\\Payload';
        }

        $members = [];
        $members[] = '    protected Method $method = Method::'.$operation->method.";\n";

        if ([] !== $operation->parameters) {
            $members[] = self::doc($this->paramLines($operation->parameters, false, true), '    ')
                .$this->signature('    public function __construct', $operation->parameters, 'private readonly ')
                .(count($operation->parameters) > 1 ? " {\n    }\n" : "\n    {\n    }\n");
        }

        $members[] = "    public function resolveEndpoint(): string\n    {\n        return ".$this->endpoint($operation).";\n    }\n";

        if ([] !== $query) {
            $members[] = self::doc(['@return array<string, mixed>'], '    ')
                ."    protected function defaultQuery(): array\n    {\n        return Payload::query([\n"
                .$this->fieldLines($query)
                ."        ]);\n    }\n";
        }

        $body = $this->requestBody($operation);

        if ('' !== $body) {
            $members[] = $body;
        }

        return self::file(
            self::ROOT.'\\Requests\\'.$operation->resource,
            $imports,
            self::doc([$operation->summary.' — `'.$operation->method.' '.$operation->path.'`.', '', self::NOTICE, '', '@internal'], '')
            .'final class '.$operation->name.' extends Request'.$implements."\n{\n".$traits.implode("\n", $members)."}\n",
        );
    }

    /**
     * @param list<Operation> $operations opérations d'une même ressource
     */
    public function resource(string $resource, array $operations): string
    {
        $imports = [self::ROOT.'\\Http\\Connector\\LemlistConnector'];
        $methods = [];

        foreach ($operations as $operation) {
            $imports[] = self::ROOT.'\\Requests\\'.$resource.'\\'.$operation->name;

            $imports[] = self::ROOT.'\\Http\\Connector\\ResponseDecoder';

            if (null !== $operation->returns->dto) {
                $imports[] = self::ROOT.'\\Dto\\'.$operation->returns->dto;
            }

            $methods[] = $this->resourceMethod($operation);
        }

        $shortNames = array_map(static fn (string $import): string => substr($import, (int) strrpos($import, '\\') + 1), array_unique($imports));

        if (count($shortNames) !== count(array_unique($shortNames)) || in_array($resource, $shortNames, true)) {
            throw new GeneratorException(sprintf('Ressource %s : deux classes importées portent le même nom court.', $resource));
        }

        return self::file(
            self::ROOT.'\\Resource',
            $imports,
            self::doc(['Section « '.$resource.' » de l\'API lemlist.', '', self::NOTICE], '')
            .'final class '.$resource."\n{\n"
            .self::doc(['@internal'], '    ')
            ."    public function __construct(private readonly LemlistConnector \$connector)\n    {\n    }\n\n"
            .implode("\n", $methods)
            ."}\n",
        );
    }

    /**
     * @param list<string> $resources
     */
    public function accessors(array $resources): string
    {
        $methods = [];

        foreach ($resources as $resource) {
            $methods[] = '    public function '.Naming::camel($resource).'(): '.$resource."\n    {\n        return new ".$resource."(\$this->connector);\n    }\n";
        }

        return self::file(
            self::ROOT.'\\Resource',
            [],
            self::doc(['Points d\'entrée de la façade {@see \\'.self::ROOT.'\\Lemlist}, un par section de l\'API.', '', self::NOTICE], '')
            ."trait ResourceAccessors\n{\n".implode("\n", $methods)."}\n",
        );
    }

    public function dto(DtoClass $class): string
    {
        $documented = [];
        $promoted = '';
        $assignments = '';

        foreach ($class->properties as $property) {
            if (null !== $property->docType) {
                $documented[] = [$property->docType.'|null', $property->name, ''];
            }

            $promoted .= '        public '.$property->nativeType().' $'.$property->name." = null,\n";
            $assignments .= '            '.$property->name.': '.sprintf($property->cast, '$data['.var_export($property->name, true).'] ?? null').",\n";
        }

        $documented[] = ['array<array-key, mixed>', 'raw', 'corps d\'origine, champs non documentés compris'];
        $needsCast = [] !== array_filter($class->properties, static fn (DtoProperty $property): bool => 'mixed' !== $property->type);

        return self::file(
            self::ROOT.'\\Dto',
            $needsCast ? [self::ROOT.'\\Support\\Cast'] : [],
            self::doc(['Schéma `'.$class->origin.'` de la spec lemlist.', '', self::NOTICE], '')
            .'final readonly class '.$class->name."\n{\n"
            .self::doc(self::alignParams($documented), '    ')
            ."    public function __construct(\n".$promoted."        public array \$raw = [],\n    ) {\n    }\n\n"
            .self::doc(['Toute valeur absente ou d\'un type inattendu devient `null` ; elle reste', 'lisible dans `raw`.', '', '@param array<array-key, mixed> $data'], '    ')
            ."    public static function fromArray(array \$data): self\n    {\n        return new self(\n"
            .$assignments
            ."            raw: \$data,\n        );\n    }\n}\n",
        );
    }

    private function requestBody(Operation $operation): string
    {
        switch ($operation->bodyKind) {
            case Operation::BODY_OBJECT:
                $additional = '';

                foreach ($operation->parametersIn(Parameter::ADDITIONAL) as $parameter) {
                    $additional = ', $this->'.$this->property($parameter);
                }

                return self::doc(['@return array<string, mixed>'], '    ')
                    ."    protected function defaultBody(): array\n    {\n        return Payload::body([\n"
                    .$this->fieldLines($operation->parametersIn(Parameter::BODY))
                    .'        ]'.$additional.");\n    }\n";
            case Operation::BODY_LIST:
                $items = $operation->parametersIn(Parameter::ITEMS)[0];

                return self::doc(['@return '.$items->documentedType()], '    ')
                    ."    protected function defaultBody(): array\n    {\n        return \$this->".$this->property($items).";\n    }\n";
            case Operation::BODY_MULTIPART:
                $values = '';

                foreach ($operation->parametersIn(Parameter::FILE) as $file) {
                    $values .= sprintf(
                        "            new MultipartValue(%s, Payload::file(\$this->%s), basename(\$this->%s)),\n",
                        var_export($file->name, true),
                        $this->property($file),
                        $this->property($file),
                    );
                }

                return self::doc(['@return list<MultipartValue>'], '    ')
                    ."    protected function defaultBody(): array\n    {\n        return [\n".$values."        ];\n    }\n";
            default:
                return '';
        }
    }

    private function resourceMethod(Operation $operation): string
    {
        $returns = $operation->returns;
        $doc = [$operation->summary.'.', '', '`'.$operation->method.' '.$operation->path.'`'];
        $params = $this->paramLines($operation->parameters, true, false);

        if ([] !== $params) {
            array_push($doc, '', ...$params);
        }

        $returnDoc = match ($returns->kind) {
            Returns::DTOS => '@return list<'.$returns->dto.'>',
            Returns::DECODED => '@return array<array-key, mixed>',
            default => null,
        };

        if (null !== $returnDoc) {
            array_push($doc, '', $returnDoc);
        }

        $returnType = match ($returns->kind) {
            Returns::DTO => (string) $returns->dto,
            Returns::DTOS, Returns::DECODED => 'array',
            Returns::TEXT => 'string',
            default => 'mixed',
        };

        $arguments = array_map(fn (Parameter $parameter): string => $this->property($parameter).': $'.$parameter->name, $operation->parameters);
        $new = match (true) {
            [] === $arguments => 'new '.$operation->name.'()',
            count($arguments) <= 2 => 'new '.$operation->name.'('.implode(', ', $arguments).')',
            default => 'new '.$operation->name."(\n            ".implode(",\n            ", $arguments).",\n        )",
        };
        $send = '$this->connector->send('.$new.')';

        $body = match ($returns->kind) {
            Returns::DTO => '        $response = '.$send.";\n\n        return ".$returns->dto."::fromArray(ResponseDecoder::object(\$response));\n",
            Returns::DTOS => '        $response = '.$send.";\n\n        return array_map(".$returns->dto."::fromArray(...), ResponseDecoder::items(\$response));\n",
            Returns::DECODED => '        $response = '.$send.";\n\n        return ResponseDecoder::object(\$response);\n",
            Returns::TEXT => '        $response = '.$send.";\n\n        return ResponseDecoder::text(\$response);\n",
            default => '        $response = '.$send.";\n\n        return ResponseDecoder::value(\$response);\n",
        };

        return self::doc($doc, '    ')
            .$this->signature('    public function '.Naming::camel($operation->name), $operation->parameters, '', 2)
            .': '.$returnType
            .(count($operation->parameters) > 2 ? ' {' : "\n    {")
            ."\n".$body."    }\n";
    }

    /**
     * @param list<Parameter> $parameters
     */
    private function signature(string $prefix, array $parameters, string $modifiers, int $inlineUpTo = 1): string
    {
        $declarations = array_map(
            fn (Parameter $parameter): string => $parameter->declaration($modifiers, '' === $modifiers ? null : $this->property($parameter)),
            $parameters,
        );

        if (count($declarations) <= $inlineUpTo) {
            return $prefix.'('.implode(', ', $declarations).')';
        }

        return $prefix."(\n        ".implode(",\n        ", $declarations).",\n    )";
    }

    private function endpoint(Operation $operation): string
    {
        $properties = [];

        foreach ($operation->parametersIn(Parameter::PATH) as $parameter) {
            $properties['{'.$parameter->name.'}'] = $this->property($parameter);
        }

        $parts = [];

        foreach (preg_split('/(\{[^}]+\})/', $operation->path, -1, \PREG_SPLIT_DELIM_CAPTURE | \PREG_SPLIT_NO_EMPTY) ?: [] as $segment) {
            $parts[] = isset($properties[$segment])
                ? 'rawurlencode($this->'.$properties[$segment].')'
                : var_export($segment, true);
        }

        return implode('.', $parts);
    }

    /**
     * Nom de la propriété promue qui porte le paramètre dans la requête.
     */
    private function property(Parameter $parameter): string
    {
        return in_array($parameter->name, $this->reservedProperties, true) ? $parameter->name.'Value' : $parameter->name;
    }

    /**
     * @param list<Parameter> $parameters
     */
    private function fieldLines(array $parameters): string
    {
        $lines = '';

        foreach ($parameters as $parameter) {
            $lines .= '            '.var_export($parameter->name, true).' => $this->'.$this->property($parameter).",\n";
        }

        return $lines;
    }

    /**
     * Lignes `@param` : celles dont le type natif ne dit pas tout, et — pour
     * l'API publique — celles que la spec décrit.
     *
     * @param list<Parameter> $parameters
     *
     * @return list<string>
     */
    private function paramLines(array $parameters, bool $withDescriptions, bool $asProperties): array
    {
        $documented = [];

        foreach ($parameters as $parameter) {
            $description = $withDescriptions ? $parameter->description : '';

            if (null !== $parameter->docType || '' !== $description) {
                $documented[] = [$parameter->documentedType(), $asProperties ? $this->property($parameter) : $parameter->name, $description];
            }
        }

        return self::alignParams($documented);
    }

    /**
     * Alignement vertical de la règle `phpdoc_align`.
     *
     * @param list<array{string, string, string}> $params type, nom, description
     *
     * @return list<string>
     */
    private static function alignParams(array $params): array
    {
        $typeWidth = 0;
        $nameWidth = 0;

        foreach ($params as [$type, $name]) {
            $typeWidth = max($typeWidth, strlen($type));
            $nameWidth = max($nameWidth, strlen($name) + 1);
        }

        $lines = [];

        foreach ($params as [$type, $name, $description]) {
            $line = '@param '.str_pad($type, $typeWidth).' ';
            $lines[] = '' === $description ? $line.'$'.$name : $line.str_pad('$'.$name, $nameWidth).' '.$description;
        }

        return $lines;
    }

    /**
     * @param list<string> $lines
     */
    private static function doc(array $lines, string $indent): string
    {
        if ([] === $lines) {
            return '';
        }

        $doc = $indent."/**\n";

        foreach ($lines as $line) {
            $doc .= rtrim($indent.' * '.$line)."\n";
        }

        return $doc.$indent." */\n";
    }

    /**
     * @param list<string> $imports
     */
    private static function file(string $namespace, array $imports, string $code): string
    {
        $imports = array_values(array_unique($imports));
        usort($imports, static fn (string $a, string $b): int => strcasecmp(str_replace('\\', ' ', $a), str_replace('\\', ' ', $b)));

        $uses = '';

        foreach ($imports as $import) {
            $uses .= 'use '.$import.";\n";
        }

        return "<?php\n\ndeclare(strict_types=1);\n\nnamespace ".$namespace.";\n\n".('' === $uses ? '' : $uses."\n").$code;
    }
}
