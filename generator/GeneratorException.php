<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Generator;

/**
 * La spec contient une construction que le générateur ne sait pas traduire :
 * mieux vaut s'arrêter que produire un code faux.
 */
final class GeneratorException extends \RuntimeException
{
}
