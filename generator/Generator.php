<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Generator;

/**
 * Produit, depuis la spec OpenAPI, les requêtes, les ressources et les DTO du
 * SDK. Le cœur — transport, erreurs, façade — reste écrit à la main.
 */
final class Generator
{
    /**
     * Répertoires de `src/` entièrement possédés par le générateur : ils sont
     * vidés avant chaque écriture, pour qu'une opération retirée de la spec ne
     * laisse pas de classe orpheline.
     */
    public const array OWNED_DIRECTORIES = ['Requests', 'Resource', 'Dto'];

    /**
     * @param array<string, string> $names noms déjà attribués
     *
     * @return array{files: array<string, string>, names: array<string, string>}
     */
    public function generate(Spec $spec, array $names): array
    {
        $dtos = new DtoPlanner($spec);
        $operations = (new Analyzer($spec, $dtos))->operations($names);
        $renderer = new Renderer();
        $files = [];
        $assigned = [];
        $byResource = [];

        foreach ($operations as $operation) {
            $files['Requests/'.$operation->resource.'/'.$operation->name.'.php'] = $renderer->request($operation);
            $assigned[$operation->key()] = $operation->resource.'/'.$operation->name;
            $byResource[$operation->resource][] = $operation;
        }

        ksort($byResource);

        foreach ($byResource as $resource => $resourceOperations) {
            $files['Resource/'.$resource.'.php'] = $renderer->resource($resource, $resourceOperations);
        }

        $files['Resource/ResourceAccessors.php'] = $renderer->accessors(array_keys($byResource));

        foreach ($dtos->classes() as $class) {
            $files['Dto/'.$class->name.'.php'] = $renderer->dto($class);
        }

        ksort($assigned);

        return ['files' => $files, 'names' => $assigned];
    }

    /**
     * @return array{operations: int, files: int}
     */
    public function run(string $specPath, string $namesPath, string $sourceDirectory): array
    {
        $result = $this->generate(Spec::fromFile($specPath), self::readNames($namesPath));

        foreach (self::OWNED_DIRECTORIES as $directory) {
            self::remove($sourceDirectory.'/'.$directory);
        }

        foreach ($result['files'] as $path => $code) {
            $target = $sourceDirectory.'/'.$path;

            if (!is_dir(dirname($target))) {
                mkdir(dirname($target), 0o775, true);
            }

            file_put_contents($target, $code);
        }

        file_put_contents(
            $namesPath,
            json_encode($result['names'], \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES | \JSON_THROW_ON_ERROR)."\n",
        );

        return ['operations' => count($result['names']), 'files' => count($result['files'])];
    }

    /**
     * @return array<string, string>
     */
    private static function readNames(string $path): array
    {
        if (!is_file($path)) {
            return [];
        }

        $names = [];

        $decoded = json_decode((string) file_get_contents($path), true, flags: \JSON_THROW_ON_ERROR);

        if (!is_array($decoded)) {
            throw new GeneratorException(sprintf('%s doit contenir un objet JSON.', $path));
        }

        foreach ($decoded as $key => $name) {
            if (is_string($key) && is_string($name)) {
                $names[$key] = $name;
            }
        }

        return $names;
    }

    private static function remove(string $directory): void
    {
        if (!is_dir($directory)) {
            return;
        }

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
