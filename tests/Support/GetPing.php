<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests\Support;

use Saloon\Enums\Method;
use Saloon\Http\Request;

final class GetPing extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/ping';
    }
}
