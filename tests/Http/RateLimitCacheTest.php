<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests\Http;

use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Tests\Support\GetPing;
use Noneo\Sdk\Lemlist\Tests\Support\SdkTestCase;
use Noneo\Sdk\Lemlist\Tests\Support\StrictPsr16Cache;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

final class RateLimitCacheTest extends SdkTestCase
{
    public function testTheCounterIsStoredUnderAKeyAStrictPsr16CacheAccepts(): void
    {
        $cache = new StrictPsr16Cache();

        $this->sendPing($cache, 'secret-key');

        self::assertCount(1, $cache->values);
    }

    public function testTheCacheKeyNeverCarriesTheApiKey(): void
    {
        $cache = new StrictPsr16Cache();

        $this->sendPing($cache, 'secret-key');

        self::assertStringNotContainsString('secret-key', (string) array_key_first($cache->values));
    }

    public function testTwoApiKeysDoNotShareACounter(): void
    {
        $cache = new StrictPsr16Cache();

        $this->sendPing($cache, 'first-key');
        $this->sendPing($cache, 'second-key');
        $this->sendPing($cache, 'second-key');

        self::assertCount(2, $cache->values);
    }

    private function sendPing(StrictPsr16Cache $cache, string $apiKey): void
    {
        $connector = new LemlistConnector($apiKey, rateLimitCache: $cache);
        $connector->withMockClient(new MockClient([MockResponse::make(['ok' => true])]));
        $connector->send(new GetPing());
    }
}
