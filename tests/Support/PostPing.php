<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests\Support;

use Saloon\Enums\Method;
use Saloon\Http\Request;

final class PostPing extends Request
{
    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/ping';
    }
}
