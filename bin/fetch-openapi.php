<?php

declare(strict_types=1);

// Télécharge la spec OpenAPI publiée par lemlist et la réindente, pour qu'elle
// reste lisible et que ses évolutions se lisent dans un diff. À faire suivre de
// `composer generate`.

const SPEC_URL = 'https://developer.lemlist.com/api-reference/openapi/v2.json';

$target = dirname(__DIR__).'/lemlist-api-v2.json';

fwrite(\STDOUT, sprintf("Récupération de %s...\n", SPEC_URL));

$json = @file_get_contents(SPEC_URL, false, stream_context_create(['http' => ['timeout' => 60]]));

if (false === $json) {
    fwrite(\STDERR, "Téléchargement impossible.\n");

    exit(1);
}

try {
    // Décodage en objets, pas en tableaux : un `{}` de la spec ne doit pas
    // ressortir en `[]`.
    $spec = json_decode($json, false, flags: \JSON_THROW_ON_ERROR);
} catch (JsonException $exception) {
    fwrite(\STDERR, sprintf("Réponse inexploitable : %s\n", $exception->getMessage()));

    exit(1);
}

if (!$spec instanceof stdClass || !isset($spec->paths) || !$spec->paths instanceof stdClass) {
    fwrite(\STDERR, "Le document reçu n'est pas une spec OpenAPI.\n");

    exit(1);
}

file_put_contents(
    $target,
    json_encode($spec, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE | \JSON_THROW_ON_ERROR)."\n",
);

fwrite(\STDOUT, sprintf("%d chemins écrits dans %s\n", count(get_object_vars($spec->paths)), basename($target)));
