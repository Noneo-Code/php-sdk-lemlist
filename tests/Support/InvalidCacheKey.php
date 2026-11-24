<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests\Support;

use Psr\SimpleCache\InvalidArgumentException;

final class InvalidCacheKey extends \InvalidArgumentException implements InvalidArgumentException
{
}
