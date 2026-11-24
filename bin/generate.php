<?php

declare(strict_types=1);

use Noneo\Sdk\Lemlist\Generator\Generator;
use Noneo\Sdk\Lemlist\Generator\GeneratorException;

require __DIR__.'/../vendor/autoload.php';

$root = dirname(__DIR__);

try {
    $result = (new Generator())->run(
        $root.'/lemlist-api-v2.json',
        $root.'/generator/operations.json',
        $root.'/src',
    );
} catch (GeneratorException $exception) {
    fwrite(\STDERR, $exception->getMessage()."\n");

    exit(1);
}

printf("%d opérations, %d fichiers générés.\n", $result['operations'], $result['files']);

// Le rendu vise déjà le format `@Symfony` ; ce passage rattrape ce qui lui
// aurait échappé, pour que `composer cs` reste vert après une régénération.
$fixer = $root.'/vendor/bin/php-cs-fixer';

if (is_file($fixer)) {
    $paths = array_map(
        static fn (string $directory): string => escapeshellarg($root.'/src/'.$directory),
        Generator::OWNED_DIRECTORIES,
    );

    passthru(sprintf(
        '%s %s fix --quiet --config=%s %s',
        escapeshellarg(\PHP_BINARY),
        escapeshellarg($fixer),
        escapeshellarg($root.'/.php-cs-fixer.php'),
        implode(' ', $paths),
    ), $status);

    exit($status);
}
