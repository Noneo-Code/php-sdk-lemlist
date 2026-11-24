<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests\Generated;

use Noneo\Sdk\Lemlist\Lemlist;
use Noneo\Sdk\Lemlist\Tests\Support\SdkTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Saloon\Contracts\Body\HasBody;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Repositories\Body\MultipartBodyRepository;

/**
 * Confronte le code généré à la spec OpenAPI committée, relue ici sans passer
 * par le générateur : une erreur de lecture de celui-ci ne peut donc pas se
 * valider elle-même. Seul `generator/operations.json` — la table des noms —
 * fait le lien entre une opération et sa classe.
 */
final class SpecConformityTest extends SdkTestCase
{
    private const array HTTP_METHODS = ['get', 'post', 'put', 'patch', 'delete'];

    private static ?string $upload = null;

    public static function tearDownAfterClass(): void
    {
        if (null !== self::$upload) {
            @unlink(self::$upload);
            self::$upload = null;
        }
    }

    public function testTheSpecIsFullyCovered(): void
    {
        $operations = iterator_to_array(self::operations());

        $documented = array_keys($operations);
        $named = array_keys(self::names());
        sort($documented);
        sort($named);

        self::assertGreaterThan(200, count($documented));
        self::assertSame(
            $documented,
            $named,
            'generator/operations.json doit lister exactement les opérations non dépréciées de la spec.',
        );
    }

    /**
     * @param array<array-key, mixed> $operation
     * @param array<array-key, mixed> $pathItem
     */
    #[DataProvider('operations')]
    public function testEveryOperationHasAConformingRequest(string $method, string $path, array $operation, array $pathItem): void
    {
        $class = self::requestClass($method, $path);
        self::assertTrue(class_exists($class), sprintf('Classe %s absente.', $class));

        $request = new $class(...self::placeholders((new \ReflectionClass($class))->getConstructor()));
        self::assertInstanceOf(Request::class, $request);

        self::assertSame($method, $request->getMethod()->value);
        self::assertSame($path, rawurldecode($request->resolveEndpoint()));

        $expectedQuery = self::parameterNames($operation, $pathItem, 'query');
        $actualQuery = array_keys($request->query()->all());
        sort($actualQuery);
        self::assertSame($expectedQuery, $actualQuery, 'Paramètres de requête.');

        $expectedBody = self::bodyFields($operation);

        if (null === $expectedBody) {
            self::assertNotInstanceOf(HasBody::class, $request);

            return;
        }

        self::assertInstanceOf(HasBody::class, $request);
        $body = $request->body();

        if ($body instanceof MultipartBodyRepository) {
            return;
        }

        $sent = $body->all();
        self::assertIsArray($sent);

        if ('list' === $expectedBody['kind']) {
            self::assertTrue(array_is_list($sent), 'Le corps devait être une liste.');

            return;
        }

        $actualBody = array_keys($sent);
        sort($actualBody);
        self::assertSame($expectedBody['fields'], $actualBody, 'Champs du corps.');
    }

    /**
     * @param array<array-key, mixed> $operation
     */
    #[DataProvider('operations')]
    public function testEveryOperationIsCallableFromTheFacade(string $method, string $path, array $operation): void
    {
        [$resource, $name] = explode('/', self::names()[$method.' '.$path]);

        $mockClient = new MockClient(['*' => MockResponse::make('[]')]);
        $lemlist = new Lemlist('secret-key');
        $lemlist->connector()->withMockClient($mockClient);

        $accessor = lcfirst($resource);
        self::assertTrue(method_exists($lemlist, $accessor), sprintf('Lemlist::%s() absente.', $accessor));
        $api = $lemlist->{$accessor}();
        self::assertIsObject($api);

        $methodName = lcfirst($name);
        self::assertTrue(method_exists($api, $methodName), sprintf('%s::%s() absente.', $api::class, $methodName));
        $reflection = new \ReflectionMethod($api, $methodName);

        $reflection->invokeArgs($api, self::placeholders($reflection));

        $mockClient->assertSent(self::requestClass($method, $path));
        self::assertSame(self::expectedReturnType($operation), (string) $reflection->getReturnType());
    }

    /**
     * Les exemples de réponse que publie lemlist servent de jeux d'essai :
     * chaque valeur documentée doit se retrouver, typée, dans le DTO.
     *
     * @param array<array-key, mixed> $example
     */
    #[DataProvider('documentedDtoExamples')]
    public function testADocumentedExampleDecodesIntoItsDto(string $method, string $path, array $example): void
    {
        [$resource, $name] = explode('/', self::names()[$method.' '.$path]);

        $lemlist = new Lemlist('secret-key');
        $lemlist->connector()->withMockClient(new MockClient(['*' => MockResponse::make($example)]));

        $api = $lemlist->{lcfirst($resource)}();
        self::assertIsObject($api);
        $reflection = new \ReflectionMethod($api, lcfirst($name));
        $result = $reflection->invokeArgs($api, self::placeholders($reflection));

        if (is_array($result)) {
            self::assertTrue(array_is_list($example), 'Une liste de DTO attend un exemple en liste.');
            self::assertCount(count($example), $result);
            $result = $result[0] ?? null;
            $example = $example[0] ?? null;
        }

        self::assertIsObject($result);
        self::assertIsArray($example);
        self::assertSame($example, (new \ReflectionProperty($result, 'raw'))->getValue($result));

        foreach ((new \ReflectionClass($result))->getProperties() as $property) {
            $documented = $example[$property->getName()] ?? null;
            $type = $property->getType();

            if ('raw' === $property->getName() || null === $documented || !$type instanceof \ReflectionNamedType) {
                continue;
            }

            $actual = $property->getValue($result);
            $label = sprintf('%s::$%s', $result::class, $property->getName());

            match (true) {
                'string' === $type->getName() && is_string($documented),
                'int' === $type->getName() && is_int($documented),
                'bool' === $type->getName() && is_bool($documented) => self::assertSame($documented, $actual, $label),
                'float' === $type->getName() && (is_int($documented) || is_float($documented)) => self::assertSame((float) $documented, $actual, $label),
                \DateTimeImmutable::class === $type->getName() && is_string($documented) && false !== strtotime($documented),
                'array' === $type->getName() && is_array($documented),
                !$type->isBuiltin() && \DateTimeImmutable::class !== $type->getName() && is_array($documented) => self::assertNotNull($actual, $label),
                // L'exemple contredit le type que la spec déclare : le DTO s'en
                // tient au type déclaré, la valeur reste lisible dans `raw`.
                default => null,
            };
        }
    }

    /**
     * @return \Generator<string, array{string, string, array<array-key, mixed>}>
     */
    public static function documentedDtoExamples(): \Generator
    {
        foreach (self::operations() as $key => [$method, $path, $operation]) {
            $schema = self::dig(self::successContent($operation), 'application/json', 'schema');
            $items = self::dig($schema, 'items');
            $isDto = is_array($schema) && null !== self::referenceName($schema) && self::describesObject(self::resolve($schema));
            $isDtoList = is_array($items) && null !== self::referenceName($items) && self::describesObject(self::resolve($items));

            $content = self::successContent($operation);

            // JSON ou CSV selon `format` : la méthode rend la valeur brute.
            if ((!$isDto && !$isDtoList) || !is_array($content) || count($content) > 1) {
                continue;
            }

            $media = self::dig(self::successContent($operation), 'application/json');
            $example = self::dig($media, 'example');
            $examples = self::dig($media, 'examples');

            if (!is_array($example) && is_array($examples) && [] !== $examples) {
                $example = self::dig(reset($examples), 'value');
            }

            if (is_array($example) && [] !== $example) {
                yield $key => [$method, $path, $example];
            }
        }
    }

    /**
     * @return \Generator<string, array{string, string, array<array-key, mixed>, array<array-key, mixed>}>
     */
    public static function operations(): \Generator
    {
        $paths = self::spec()['paths'] ?? null;
        self::assertIsArray($paths);

        foreach ($paths as $path => $pathItem) {
            self::assertIsString($path);
            self::assertIsArray($pathItem);

            foreach (self::HTTP_METHODS as $method) {
                $operation = $pathItem[$method] ?? null;

                if (!is_array($operation) || true === ($operation['deprecated'] ?? false)) {
                    continue;
                }

                /* @var array<string, mixed> $operation */
                /* @var array<string, mixed> $pathItem */
                yield strtoupper($method).' '.$path => [strtoupper($method), $path, $operation, $pathItem];
            }
        }
    }

    /**
     * @return class-string
     */
    private static function requestClass(string $method, string $path): string
    {
        $name = self::names()[$method.' '.$path] ?? null;
        self::assertIsString($name, sprintf('%s %s absent de generator/operations.json.', $method, $path));

        /** @var class-string $class */
        $class = 'Noneo\\Sdk\\Lemlist\\Requests\\'.str_replace('/', '\\', $name);

        return $class;
    }

    /**
     * Une valeur par paramètre, optionnels compris, pour que requête et corps
     * portent tout ce que la classe sait envoyer.
     *
     * @return array<string, mixed>
     */
    private static function placeholders(?\ReflectionMethod $method): array
    {
        $arguments = [];

        foreach ($method?->getParameters() ?? [] as $parameter) {
            $name = $parameter->getName();
            $type = ltrim((string) $parameter->getType(), '?');
            $types = explode('|', $type);

            $arguments[$name] = match (true) {
                'additional' === $name => ['additionalKey' => 'value'],
                'file' === $name => self::upload(),
                'items' === $name && 'array' === $type => [['key' => 'value']],
                in_array('string', $types, true) => '{'.$name.'}',
                'int' === $type => 7,
                'float' === $type => 1.5,
                'bool' === $type => true,
                'array' === $type => ['key' => 'value'],
                default => 'value',
            };
        }

        return $arguments;
    }

    private static function upload(): string
    {
        if (null === self::$upload) {
            $path = tempnam(sys_get_temp_dir(), 'lemlist-sdk-');
            self::assertIsString($path);
            file_put_contents($path, 'audio');
            self::$upload = $path;
        }

        return self::$upload;
    }

    /**
     * @param array<array-key, mixed> $operation
     * @param array<array-key, mixed> $pathItem
     *
     * @return list<string>
     */
    private static function parameterNames(array $operation, array $pathItem, string $in): array
    {
        $names = [];

        foreach ([$pathItem['parameters'] ?? [], $operation['parameters'] ?? []] as $parameters) {
            self::assertIsArray($parameters);

            foreach ($parameters as $parameter) {
                if (is_array($parameter) && $in === ($parameter['in'] ?? null) && is_string($parameter['name'] ?? null)) {
                    $names[$parameter['name']] = true;
                }
            }
        }

        $names = array_keys($names);
        sort($names);

        return $names;
    }

    /**
     * @param array<array-key, mixed> $operation
     *
     * @return array{kind: string, fields: list<string>}|null
     */
    private static function bodyFields(array $operation): ?array
    {
        $content = self::dig($operation, 'requestBody', 'content');

        if (!is_array($content) || [] === $content) {
            return null;
        }

        $schema = self::resolve(self::dig(reset($content), 'schema'));

        if ('array' === ($schema['type'] ?? null)) {
            return ['kind' => 'list', 'fields' => []];
        }

        $properties = $schema['properties'] ?? [];
        self::assertIsArray($properties);
        $fields = array_map(strval(...), array_keys($properties));

        if (false !== ($schema['additionalProperties'] ?? false)) {
            $fields[] = 'additionalKey';
        }

        sort($fields);

        return ['kind' => 'object', 'fields' => $fields];
    }

    /**
     * Le contrat « hybride » : un DTO là où la spec nomme un schéma objet, un
     * tableau décodé là où elle décrit la réponse de façon anonyme.
     *
     * @param array<array-key, mixed> $operation
     */
    private static function expectedReturnType(array $operation): string
    {
        $content = self::successContent($operation);

        // Rien de documenté ne veut pas dire rien de renvoyé : la valeur reçue
        // est rendue telle quelle plutôt que jetée.
        if (!is_array($content) || [] === $content) {
            return 'mixed';
        }

        if (!array_key_exists('application/json', $content)) {
            return 'string';
        }

        // Un endpoint qui rend du JSON ou du CSV selon un paramètre `format`
        // ne peut promettre ni l'un ni l'autre.
        if (count($content) > 1) {
            return 'mixed';
        }

        $schema = self::dig($content['application/json'], 'schema');

        if (!is_array($schema) || [] === $schema) {
            return 'mixed';
        }

        $reference = self::referenceName($schema);

        if (null !== $reference && self::describesObject(self::resolve($schema))) {
            return 'Noneo\\Sdk\\Lemlist\\Dto\\'.$reference.'Dto';
        }

        $resolved = self::resolve($schema);

        if (self::describesObject($resolved) || 'array' === ($resolved['type'] ?? null)) {
            return 'array';
        }

        if (isset($resolved['oneOf']) || isset($resolved['anyOf'])) {
            return 'array';
        }

        return 'mixed';
    }

    /**
     * Contenu de la première réponse de succès documentée.
     *
     * @param array<array-key, mixed> $operation
     */
    private static function successContent(array $operation): mixed
    {
        $responses = $operation['responses'] ?? [];
        self::assertIsArray($responses);
        $codes = array_filter(array_map(strval(...), array_keys($responses)), static fn (string $code): bool => str_starts_with($code, '2'));
        sort($codes);
        self::assertNotSame([], $codes);

        return self::dig($responses[$codes[0]] ?? $responses[(int) $codes[0]], 'content');
    }

    /**
     * @param array<array-key, mixed> $schema
     */
    private static function describesObject(array $schema): bool
    {
        return 'object' === ($schema['type'] ?? null) || (is_array($schema['properties'] ?? null) && [] !== $schema['properties']);
    }

    /**
     * @param array<array-key, mixed> $schema
     */
    private static function referenceName(array $schema): ?string
    {
        $reference = $schema['$ref'] ?? null;

        return is_string($reference) ? substr($reference, (int) strrpos($reference, '/') + 1) : null;
    }

    /**
     * @return array<array-key, mixed>
     */
    private static function resolve(mixed $schema): array
    {
        if (!is_array($schema)) {
            return [];
        }

        $name = self::referenceName($schema);

        if (null === $name) {
            return $schema;
        }

        return self::resolve(self::dig(self::spec(), 'components', 'schemas', $name));
    }

    private static function dig(mixed $value, string ...$keys): mixed
    {
        foreach ($keys as $key) {
            if (!is_array($value)) {
                return null;
            }

            $value = $value[$key] ?? null;
        }

        return $value;
    }

    /**
     * @return array<string, string>
     */
    private static function names(): array
    {
        /** @var array<string, string>|null $names */
        static $names = null;

        if (null === $names) {
            $names = [];

            foreach (self::readJson(__DIR__.'/../../generator/operations.json') as $key => $name) {
                self::assertIsString($key);
                self::assertIsString($name);
                $names[$key] = $name;
            }
        }

        return $names;
    }

    /**
     * @return array<array-key, mixed>
     */
    private static function spec(): array
    {
        /** @var array<array-key, mixed>|null $spec */
        static $spec = null;

        return $spec ??= self::readJson(__DIR__.'/../../lemlist-api-v2.json');
    }

    /**
     * @return array<array-key, mixed>
     */
    private static function readJson(string $path): array
    {
        $json = file_get_contents($path);
        self::assertIsString($json, sprintf('%s est illisible.', $path));
        $decoded = json_decode($json, true, flags: \JSON_THROW_ON_ERROR);
        self::assertIsArray($decoded);

        return $decoded;
    }
}
