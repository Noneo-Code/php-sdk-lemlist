<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests\Http;

use Noneo\Sdk\Lemlist\Exception\RateLimitException;
use Noneo\Sdk\Lemlist\Exception\ServerException;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Tests\Support\GetPing;
use Noneo\Sdk\Lemlist\Tests\Support\PostPing;
use Noneo\Sdk\Lemlist\Tests\Support\SdkTestCase;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;

final class RetryTest extends SdkTestCase
{
    /**
     * @var list<float>
     */
    private array $waits = [];

    public function testARateLimitedRequestIsReplayedAfterTheServerDelay(): void
    {
        $mockClient = new MockClient([
            MockResponse::make('Too many requests', 429, ['Retry-After' => '2']),
            MockResponse::make(['ok' => true]),
        ]);

        $response = $this->connector($mockClient)->send(new GetPing());

        self::assertSame(200, $response->status());
        self::assertSame([2.0], $this->waits);
        $mockClient->assertSentCount(2);
    }

    public function testARateLimitedWriteIsReplayedToo(): void
    {
        $mockClient = new MockClient([
            MockResponse::make('Too many requests', 429, ['Retry-After' => '1']),
            MockResponse::make(['ok' => true]),
        ]);

        $this->connector($mockClient)->send(new PostPing());

        $mockClient->assertSentCount(2);
    }

    public function testAnAberrantRetryAfterIsCapped(): void
    {
        $mockClient = new MockClient([
            MockResponse::make('Too many requests', 429, ['Retry-After' => '3600']),
            MockResponse::make(['ok' => true]),
        ]);

        $this->connector($mockClient)->send(new GetPing());

        self::assertSame([60.0], $this->waits);
    }

    public function testAServerErrorOnAReadIsReplayedWithABackoff(): void
    {
        $mockClient = new MockClient([
            MockResponse::make('Bad gateway', 502),
            MockResponse::make('Bad gateway', 502),
            MockResponse::make(['ok' => true]),
        ]);

        $this->connector($mockClient)->send(new GetPing());

        $mockClient->assertSentCount(3);
        self::assertCount(2, $this->waits);
        self::assertGreaterThan(0.0, $this->waits[0]);
        self::assertLessThanOrEqual(0.5, $this->waits[0]);
        self::assertLessThanOrEqual(1.0, $this->waits[1]);
    }

    public function testAServerErrorOnAWriteIsNeverReplayed(): void
    {
        $mockClient = new MockClient([
            MockResponse::make('Bad gateway', 502),
            MockResponse::make(['ok' => true]),
        ]);

        try {
            $this->connector($mockClient)->send(new PostPing());
            self::fail('Une exception était attendue.');
        } catch (ServerException) {
            $mockClient->assertSentCount(1);
            self::assertSame([], $this->waits);
        }
    }

    public function testItGivesUpAfterTheConfiguredNumberOfRetries(): void
    {
        $mockClient = new MockClient([
            MockResponse::make('Too many requests', 429, ['Retry-After' => '1']),
            MockResponse::make('Too many requests', 429, ['Retry-After' => '1']),
            MockResponse::make('Too many requests', 429, ['Retry-After' => '1']),
        ]);

        try {
            $this->connector($mockClient, maxRetries: 2)->send(new GetPing());
            self::fail('Une exception était attendue.');
        } catch (RateLimitException) {
            $mockClient->assertSentCount(3);
            self::assertSame([1.0, 1.0], $this->waits);
        }
    }

    public function testRetriesCanBeDisabled(): void
    {
        $mockClient = new MockClient([MockResponse::make('Too many requests', 429)]);

        try {
            $this->connector($mockClient, maxRetries: 0)->send(new GetPing());
            self::fail('Une exception était attendue.');
        } catch (RateLimitException) {
            $mockClient->assertSentCount(1);
        }
    }

    public function testTheRetryBudgetIsPerRequest(): void
    {
        $mockClient = new MockClient([
            MockResponse::make('Too many requests', 429, ['Retry-After' => '1']),
            MockResponse::make(['ok' => true]),
            MockResponse::make('Too many requests', 429, ['Retry-After' => '1']),
            MockResponse::make(['ok' => true]),
        ]);
        $connector = $this->connector($mockClient, maxRetries: 1);

        $this->assertSucceeds($connector, new GetPing());
        $this->assertSucceeds($connector, new GetPing());
    }

    private function assertSucceeds(LemlistConnector $connector, Request $request): void
    {
        self::assertSame(200, $connector->send($request)->status());
    }

    private function connector(MockClient $mockClient, int $maxRetries = 3): LemlistConnector
    {
        $connector = new LemlistConnector('secret-key', maxRetries: $maxRetries);
        $connector->withMockClient($mockClient);
        $connector->useSleeper(function (float $seconds): void {
            $this->waits[] = $seconds;
        });

        return $connector;
    }
}
