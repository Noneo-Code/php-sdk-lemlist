<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Generator;

/**
 * Décide quels DTO générer : un par schéma nommé atteint depuis une réponse,
 * plus un par objet décrit à l'intérieur d'un tel schéma.
 */
final class DtoPlanner
{
    private const string SUFFIX = 'Dto';

    /**
     * `null` marque un DTO en cours de construction : c'est ce qui permet à un
     * schéma de se référencer lui-même, directement ou non.
     *
     * @var array<string, DtoClass|null>
     */
    private array $classes = [];

    public function __construct(private readonly Spec $spec)
    {
    }

    /**
     * Nom du DTO d'un schéma nommé, ou `null` s'il ne décrit pas un objet.
     */
    public function forSchema(string $schemaName): ?string
    {
        $schema = $this->spec->schema($schemaName);

        if ([] === $schema->map('properties')) {
            return null;
        }

        $class = $schemaName.self::SUFFIX;

        if (!array_key_exists($class, $this->classes)) {
            $this->classes[$class] = null;
            $this->classes[$class] = $this->build($class, $schemaName, $schema);
        }

        return $class;
    }

    /**
     * @return list<DtoClass>
     */
    public function classes(): array
    {
        $classes = array_values(array_filter($this->classes));
        usort($classes, static fn (DtoClass $a, DtoClass $b): int => strcmp($a->name, $b->name));

        return $classes;
    }

    private function build(string $class, string $origin, Node $schema): DtoClass
    {
        $base = substr($class, 0, -strlen(self::SUFFIX));
        $properties = [];

        foreach ($schema->map('properties') as $name => $property) {
            if (1 !== preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $name) || in_array($name, ['this', 'raw'], true)) {
                throw new GeneratorException(sprintf('Propriété « %s » de %s : nom inutilisable en PHP.', $name, $origin));
            }

            $properties[] = $this->property($base, $origin, $name, $property);
        }

        return new DtoClass($class, $origin, $properties);
    }

    private function property(string $base, string $origin, string $name, Node $schema): DtoProperty
    {
        $reference = Spec::referenceName($schema);

        if (null !== $reference) {
            $dto = $this->forSchema($reference);

            if (null !== $dto) {
                return DtoProperty::object($name, $dto);
            }
        }

        $schema = $this->spec->resolve($schema);
        $allOf = $schema->list('allOf');

        if (1 === count($allOf)) {
            return $this->property($base, $origin, $name, $allOf[0]);
        }

        return match ($schema->string('type')) {
            'string' => 'date-time' === $schema->string('format') ? DtoProperty::dateTime($name) : DtoProperty::scalar($name, 'string'),
            'integer' => DtoProperty::scalar($name, 'int'),
            'number' => DtoProperty::scalar($name, 'float'),
            'boolean' => DtoProperty::scalar($name, 'bool'),
            'array' => $this->arrayProperty($base, $origin, $name, $schema->get('items')),
            'object' => $this->objectProperty($base, $origin, $name, $schema),
            default => [] !== $schema->map('properties')
                ? $this->objectProperty($base, $origin, $name, $schema)
                : DtoProperty::mixed($name),
        };
    }

    private function objectProperty(string $base, string $origin, string $name, Node $schema): DtoProperty
    {
        if ([] === $schema->map('properties')) {
            return DtoProperty::map($name);
        }

        return DtoProperty::object($name, $this->inline($base.Naming::pascal($name), $origin.'.'.$name, $schema));
    }

    private function arrayProperty(string $base, string $origin, string $name, Node $items): DtoProperty
    {
        $reference = Spec::referenceName($items);

        if (null !== $reference) {
            $dto = $this->forSchema($reference);

            if (null !== $dto) {
                return DtoProperty::objects($name, $dto);
            }
        }

        $items = $this->spec->resolve($items);

        if ([] !== $items->map('properties')) {
            return DtoProperty::objects(
                $name,
                $this->inline($base.Naming::pascal($name).'Item', $origin.'.'.$name.'[]', $items),
            );
        }

        return match ($items->string('type')) {
            'string' => DtoProperty::scalars($name, 'string'),
            'integer' => DtoProperty::scalars($name, 'int'),
            'number' => DtoProperty::scalars($name, 'float'),
            'boolean' => DtoProperty::scalars($name, 'bool'),
            default => DtoProperty::map($name),
        };
    }

    /**
     * DTO d'un objet décrit à l'intérieur d'un autre schéma, nommé d'après son
     * chemin. Le nom ne doit ni reprendre celui d'un schéma nommé, ni celui
     * d'un autre objet imbriqué.
     */
    private function inline(string $base, string $origin, Node $schema): string
    {
        while ($this->spec->hasSchema($base) || array_key_exists($base.self::SUFFIX, $this->classes)) {
            $base .= 'Inline';
        }

        $class = $base.self::SUFFIX;
        $this->classes[$class] = null;
        $this->classes[$class] = $this->build($class, $origin, $schema);

        return $class;
    }
}
