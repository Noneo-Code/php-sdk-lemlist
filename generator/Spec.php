<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Generator;

final readonly class Spec
{
    private const array HTTP_METHODS = ['get', 'post', 'put', 'patch', 'delete'];

    private const int MAX_REFERENCE_DEPTH = 20;

    public function __construct(private Node $root)
    {
    }

    public static function fromFile(string $path): self
    {
        $json = @file_get_contents($path);

        if (false === $json) {
            throw new GeneratorException(sprintf('Spec illisible : %s', $path));
        }

        return new self(Node::of(json_decode($json, true, flags: \JSON_THROW_ON_ERROR)));
    }

    /**
     * Opérations non dépréciées, dans l'ordre de la spec.
     *
     * @return list<array{method: string, path: string, operation: Node, pathItem: Node}>
     */
    public function operations(): array
    {
        $operations = [];

        foreach ($this->root->map('paths') as $path => $pathItem) {
            foreach (self::HTTP_METHODS as $method) {
                $operation = $pathItem->get($method);

                if ($operation->isEmpty() || true === $operation->value('deprecated')) {
                    continue;
                }

                $operations[] = [
                    'method' => strtoupper($method),
                    'path' => $path,
                    'operation' => $operation,
                    'pathItem' => $pathItem,
                ];
            }
        }

        return $operations;
    }

    public function hasSchema(string $name): bool
    {
        return $this->root->get('components')->get('schemas')->has($name);
    }

    public function schema(string $name): Node
    {
        return $this->resolve($this->root->get('components')->get('schemas')->get($name));
    }

    /**
     * Suit les `$ref` jusqu'au schéma réel.
     */
    public function resolve(Node $node): Node
    {
        for ($depth = 0; $depth < self::MAX_REFERENCE_DEPTH; ++$depth) {
            $reference = $node->string('$ref');

            if ('' === $reference) {
                return $node;
            }

            $node = $this->root;

            foreach (array_slice(explode('/', $reference), 1) as $segment) {
                $node = $node->get(str_replace(['~1', '~0'], ['/', '~'], $segment));
            }
        }

        throw new GeneratorException('Référence circulaire dans la spec.');
    }

    /**
     * Nom du schéma visé par un `$ref` direct vers `components/schemas`.
     */
    public static function referenceName(Node $node): ?string
    {
        $reference = $node->string('$ref');

        if (!str_starts_with($reference, '#/components/schemas/')) {
            return null;
        }

        return substr($reference, strlen('#/components/schemas/'));
    }

    /**
     * Un schéma « objet » au sens du générateur : il décrit des propriétés.
     */
    public static function isObject(Node $schema): bool
    {
        return 'object' === $schema->string('type') || [] !== $schema->map('properties');
    }
}
