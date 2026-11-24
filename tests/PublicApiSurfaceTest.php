<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Un consommateur instancie, utilise et teste le SDK sans rencontrer un seul
 * symbole `Saloon\*`. Toute classe hors namespaces internes est inspectée par
 * réflexion — parent, interfaces, signatures et propriétés publiques.
 */
final class PublicApiSurfaceTest extends TestCase
{
    /**
     * Namespaces internes par convention : jamais présentés comme API publique.
     */
    private const array INTERNAL_NAMESPACES = [
        'Noneo\\Sdk\\Lemlist\\Requests\\',
        'Noneo\\Sdk\\Lemlist\\Concerns\\',
        'Noneo\\Sdk\\Lemlist\\Http\\Connector\\',
    ];

    public function testNoPublicSignatureExposesASaloonType(): void
    {
        $offenders = [];
        $inspected = 0;

        foreach ($this->publicClasses() as $reflection) {
            ++$inspected;
            $parent = $reflection->getParentClass();

            if ($parent instanceof \ReflectionClass && str_starts_with($parent->getName(), 'Saloon\\')) {
                $offenders[] = sprintf('%s extends %s', $reflection->getName(), $parent->getName());
            }

            foreach ($reflection->getInterfaceNames() as $interface) {
                if (str_starts_with($interface, 'Saloon\\')) {
                    $offenders[] = sprintf('%s implements %s', $reflection->getName(), $interface);
                }
            }

            foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                if (str_contains((string) $method->getDocComment(), '@internal')) {
                    continue;
                }

                foreach ([...$method->getParameters(), $method] as $typed) {
                    $type = $typed instanceof \ReflectionMethod ? $typed->getReturnType() : $typed->getType();

                    foreach ($this->saloonNamesIn($type) as $name) {
                        $offenders[] = sprintf('%s::%s() expose %s', $reflection->getName(), $method->getName(), $name);
                    }
                }
            }

            foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
                foreach ($this->saloonNamesIn($property->getType()) as $name) {
                    $offenders[] = sprintf('%s::$%s expose %s', $reflection->getName(), $property->getName(), $name);
                }
            }
        }

        // Sans ce plancher, une erreur de chargement rendrait le test vert et muet.
        self::assertGreaterThan(150, $inspected);
        self::assertSame([], $offenders, sprintf(
            "L'API publique expose des types Saloon :\n- %s",
            implode("\n- ", $offenders),
        ));
    }

    /**
     * @return \Generator<\ReflectionClass<object>>
     */
    private function publicClasses(): \Generator
    {
        $sourceDirectory = dirname(__DIR__).'/src';

        /** @var iterable<\SplFileInfo> $files */
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($sourceDirectory));

        foreach ($files as $file) {
            if ('php' !== $file->getExtension()) {
                continue;
            }

            $relative = substr($file->getPathname(), strlen($sourceDirectory) + 1, -strlen('.php'));
            $class = 'Noneo\\Sdk\\Lemlist\\'.str_replace('/', '\\', $relative);

            foreach (self::INTERNAL_NAMESPACES as $internal) {
                if (str_starts_with($class, $internal)) {
                    continue 2;
                }
            }

            if (!class_exists($class) && !interface_exists($class)) {
                continue;
            }

            $reflection = new \ReflectionClass($class);

            if (!str_contains((string) $reflection->getDocComment(), '@internal')) {
                yield $reflection;
            }
        }
    }

    /**
     * @return list<string>
     */
    private function saloonNamesIn(?\ReflectionType $type): array
    {
        if ($type instanceof \ReflectionNamedType) {
            return str_starts_with($type->getName(), 'Saloon\\') ? [$type->getName()] : [];
        }

        if ($type instanceof \ReflectionUnionType || $type instanceof \ReflectionIntersectionType) {
            return array_merge(...array_map(
                fn (\ReflectionType $inner): array => $this->saloonNamesIn($inner),
                $type->getTypes(),
            ));
        }

        return [];
    }
}
