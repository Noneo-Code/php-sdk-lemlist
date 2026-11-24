<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests\Generator;

use Noneo\Sdk\Lemlist\Generator\Generator;
use Noneo\Sdk\Lemlist\Generator\GeneratorException;
use Noneo\Sdk\Lemlist\Generator\Node;
use Noneo\Sdk\Lemlist\Generator\Spec;
use PHPUnit\Framework\TestCase;

/**
 * Règles du générateur que la spec lemlist du moment n'exerce pas forcément,
 * vérifiées sur des specs miniatures.
 */
final class GeneratorTest extends TestCase
{
    public function testANewOperationIsNamedAfterItsTagAndSummary(): void
    {
        $result = $this->generate(['/things' => ['get' => self::operation('List the Things')]]);

        self::assertSame(['GET /things' => 'Things/ListTheThings'], $result['names']);
        self::assertArrayHasKey('Requests/Things/ListTheThings.php', $result['files']);
        self::assertStringContainsString('public function listTheThings(', $result['files']['Resource/Things.php']);
        self::assertStringContainsString('public function things(): Things', $result['files']['Resource/ResourceAccessors.php']);
    }

    public function testAnOperationIdWinsOverTheSummary(): void
    {
        $result = $this->generate(['/things' => ['get' => self::operation('List the Things') + ['operationId' => 'listThings']]]);

        self::assertSame(['GET /things' => 'Things/ListThings'], $result['names']);
    }

    public function testAnAssignedNameSurvivesARewordedSummary(): void
    {
        $result = $this->generate(
            ['/things' => ['get' => self::operation('Fetch every single Thing')]],
            names: ['GET /things' => 'Things/ListTheThings'],
        );

        self::assertSame(['GET /things' => 'Things/ListTheThings'], $result['names']);
        self::assertArrayHasKey('Requests/Things/ListTheThings.php', $result['files']);
    }

    public function testANameIsDroppedWithItsOperation(): void
    {
        $result = $this->generate(
            ['/things' => ['get' => self::operation('List Things')]],
            names: ['GET /gone' => 'Things/Gone'],
        );

        self::assertSame(['GET /things' => 'Things/ListThings'], $result['names']);
    }

    public function testTwoOperationsCannotShareAName(): void
    {
        $this->expectException(GeneratorException::class);
        $this->expectExceptionMessage('generator/operations.json');

        $this->generate([
            '/things' => ['get' => self::operation('List Things')],
            '/v2/things' => ['get' => self::operation('List Things')],
        ]);
    }

    public function testADeprecatedOperationIsSkipped(): void
    {
        $result = $this->generate([
            '/things' => [
                'get' => self::operation('List Things'),
                'delete' => self::operation('Purge Things') + ['deprecated' => true],
            ],
        ]);

        self::assertSame(['GET /things'], array_keys($result['names']));
    }

    public function testAFieldNamedLikeASaloonPropertyIsRenamedInsideTheRequestOnly(): void
    {
        $result = $this->generate(['/things' => ['post' => self::operation('Create Thing') + [
            'requestBody' => ['content' => ['application/json' => ['schema' => [
                'type' => 'object',
                'properties' => ['method' => ['type' => 'string']],
            ]]]],
        ]]]);

        $request = $result['files']['Requests/Things/CreateThing.php'];
        self::assertStringContainsString('private readonly ?string $methodValue = null', $request);
        self::assertStringContainsString("'method' => \$this->methodValue,", $request);

        $resource = $result['files']['Resource/Things.php'];
        self::assertStringContainsString('public function createThing(?string $method = null)', $resource);
        self::assertStringContainsString('new CreateThing(methodValue: $method)', $resource);
    }

    public function testASecretParameterIsMarkedSensitive(): void
    {
        $result = $this->generate(['/things' => ['post' => self::operation('Create Thing') + [
            'requestBody' => ['content' => ['application/json' => ['schema' => [
                'type' => 'object',
                'required' => ['password'],
                'properties' => ['password' => ['type' => 'string']],
            ]]]],
        ]]]);

        self::assertStringContainsString('#[\SensitiveParameter] private readonly string $password', $result['files']['Requests/Things/CreateThing.php']);
        self::assertStringContainsString('#[\SensitiveParameter] string $password', $result['files']['Resource/Things.php']);
    }

    public function testRequiredParametersComeFirst(): void
    {
        $result = $this->generate(['/things/{thingId}' => ['patch' => self::operation('Update Thing') + [
            'parameters' => [
                ['name' => 'dryRun', 'in' => 'query', 'schema' => ['type' => 'boolean']],
                ['name' => 'thingId', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'string']],
            ],
            'requestBody' => ['content' => ['application/json' => ['schema' => [
                'type' => 'object',
                'required' => ['name'],
                'properties' => ['color' => ['type' => 'string'], 'name' => ['type' => 'string']],
            ]]]],
        ]]]);

        self::assertMatchesRegularExpression(
            '/updateThing\(\s*string \$thingId,\s*string \$name,\s*\?string \$color = null,\s*\?bool \$dryRun = null,\s*\)/',
            $result['files']['Resource/Things.php'],
        );
    }

    public function testABodyWithoutDescribedPropertiesStopsTheGeneration(): void
    {
        $this->expectException(GeneratorException::class);

        $this->generate(['/things' => ['post' => self::operation('Create Thing') + [
            'requestBody' => ['content' => ['application/json' => ['schema' => ['type' => 'object']]]],
        ]]]);
    }

    public function testANamedSchemaBecomesADtoAndItsNestedObjectsToo(): void
    {
        $result = $this->generate(
            ['/things' => ['get' => self::operation('Get Thing', ['$ref' => '#/components/schemas/Thing'])]],
            schemas: [
                'Thing' => ['type' => 'object', 'properties' => [
                    'name' => ['type' => 'string'],
                    'owner' => ['type' => 'object', 'properties' => ['email' => ['type' => 'string']]],
                    'parts' => ['type' => 'array', 'items' => ['$ref' => '#/components/schemas/Part']],
                    'parent' => ['$ref' => '#/components/schemas/Thing'],
                ]],
                'Part' => ['type' => 'object', 'properties' => ['weight' => ['type' => 'number']]],
                'Unused' => ['type' => 'object', 'properties' => ['x' => ['type' => 'string']]],
            ],
        );

        self::assertStringContainsString('public function getThing(): ThingDto', $result['files']['Resource/Things.php']);

        $dto = $result['files']['Dto/ThingDto.php'];
        self::assertStringContainsString('public ?ThingOwnerDto $owner = null', $dto);
        self::assertStringContainsString('@param list<PartDto>|null', $dto);
        self::assertStringContainsString('public ?ThingDto $parent = null', $dto);
        self::assertArrayHasKey('Dto/ThingOwnerDto.php', $result['files']);
        self::assertArrayHasKey('Dto/PartDto.php', $result['files']);
        self::assertArrayNotHasKey('Dto/UnusedDto.php', $result['files'], 'Un schéma qu\'aucune réponse n\'atteint n\'a pas de DTO.');
    }

    public function testANestedObjectNeverTakesTheNameOfANamedSchema(): void
    {
        $result = $this->generate(
            ['/things' => ['get' => self::operation('Get Thing', ['$ref' => '#/components/schemas/Thing'])]],
            schemas: [
                'Thing' => ['type' => 'object', 'properties' => [
                    'owner' => ['type' => 'object', 'properties' => ['email' => ['type' => 'string']]],
                    'previousOwner' => ['$ref' => '#/components/schemas/ThingOwner'],
                ]],
                'ThingOwner' => ['type' => 'object', 'properties' => ['id' => ['type' => 'string']]],
            ],
        );

        self::assertStringContainsString('public ?ThingOwnerInlineDto $owner = null', $result['files']['Dto/ThingDto.php']);
        self::assertStringContainsString('public ?ThingOwnerDto $previousOwner = null', $result['files']['Dto/ThingDto.php']);
    }

    public function testEveryGeneratedFileIsValidPhp(): void
    {
        $result = $this->generate(
            ['/things/{thingId}' => ['put' => self::operation('Replace Thing', ['type' => 'array', 'items' => ['$ref' => '#/components/schemas/Thing']]) + [
                'parameters' => [['name' => 'thingId', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'string']]],
                'requestBody' => ['content' => ['application/json' => ['schema' => [
                    'type' => 'object',
                    'additionalProperties' => true,
                    'properties' => ['tags' => ['type' => 'array', 'items' => ['type' => 'string']], 'at' => ['type' => 'string', 'format' => 'date-time']],
                ]]]],
            ]]],
            schemas: ['Thing' => ['type' => 'object', 'properties' => ['name' => ['type' => 'string'], 'tags' => ['type' => 'array', 'items' => ['type' => 'string']]]]],
        );

        foreach ($result['files'] as $path => $code) {
            try {
                self::assertNotSame([], token_get_all($code, \TOKEN_PARSE));
            } catch (\ParseError $error) {
                self::fail(sprintf('%s : %s', $path, $error->getMessage()));
            }
        }

        self::assertCount(4, $result['files']);
    }

    public function testRunRemovesTheClassesOfOperationsThatLeftTheSpec(): void
    {
        $directory = sys_get_temp_dir().'/lemlist-generator-'.bin2hex(random_bytes(4));
        mkdir($directory.'/src/Requests/Old', 0o775, true);
        mkdir($directory.'/src/Support', 0o775, true);
        file_put_contents($directory.'/src/Requests/Old/Gone.php', '<?php');
        file_put_contents($directory.'/src/Support/Kept.php', '<?php');
        file_put_contents($directory.'/spec.json', json_encode(self::spec(['/things' => ['get' => self::operation('List Things')]]), \JSON_THROW_ON_ERROR));

        try {
            $result = (new Generator())->run($directory.'/spec.json', $directory.'/names.json', $directory.'/src');

            self::assertSame(['operations' => 1, 'files' => 3], $result);
            self::assertFileDoesNotExist($directory.'/src/Requests/Old/Gone.php');
            self::assertFileExists($directory.'/src/Requests/Things/ListThings.php');
            self::assertFileExists($directory.'/src/Support/Kept.php', 'Le générateur ne touche qu\'à ses propres répertoires.');
            self::assertJsonStringEqualsJsonString('{"GET /things": "Things/ListThings"}', (string) file_get_contents($directory.'/names.json'));
        } finally {
            self::removeDirectory($directory);
        }
    }

    /**
     * @param array<string, mixed>  $paths
     * @param array<string, string> $names
     * @param array<string, mixed>  $schemas
     *
     * @return array{files: array<string, string>, names: array<string, string>}
     */
    private function generate(array $paths, array $names = [], array $schemas = []): array
    {
        return (new Generator())->generate(new Spec(Node::of(self::spec($paths, $schemas))), $names);
    }

    /**
     * @param array<string, mixed> $paths
     * @param array<string, mixed> $schemas
     *
     * @return array<string, mixed>
     */
    private static function spec(array $paths, array $schemas = []): array
    {
        return ['paths' => $paths, 'components' => ['schemas' => $schemas]];
    }

    /**
     * @param array<string, mixed>|null $responseSchema
     *
     * @return array<string, mixed>
     */
    private static function operation(string $summary, ?array $responseSchema = null): array
    {
        return [
            'tags' => ['Things'],
            'summary' => $summary,
            'responses' => ['200' => ['content' => ['application/json' => ['schema' => $responseSchema ?? ['type' => 'object', 'properties' => ['ok' => ['type' => 'boolean']]]]]]],
        ];
    }

    private static function removeDirectory(string $directory): void
    {
        /** @var iterable<\SplFileInfo> $entries */
        $entries = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST,
        );

        foreach ($entries as $entry) {
            $entry->isDir() ? rmdir($entry->getPathname()) : unlink($entry->getPathname());
        }

        rmdir($directory);
    }
}
