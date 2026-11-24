<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests\Support;

use PHPUnit\Framework\TestCase;
use Saloon\RateLimitPlugin\Stores\MemoryStore;

/**
 * Le compteur de débit par défaut est statique, donc partagé par tous les
 * connecteurs du process : sans remise à zéro, la suite atteindrait le quota
 * de 20 requêtes par 2 secondes et s'endormirait entre deux tests.
 */
abstract class SdkTestCase extends TestCase
{
    protected function setUp(): void
    {
        MemoryStore::clear();
    }
}
