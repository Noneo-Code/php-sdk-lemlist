<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests\Http;

use GuzzleHttp\RequestOptions;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Lemlist;
use Noneo\Sdk\Lemlist\Tests\Support\GetPing;
use Noneo\Sdk\Lemlist\Tests\Support\SdkTestCase;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

final class LemlistConnectorTest extends SdkTestCase
{
    public function testItAuthenticatesWithAnEmptyLoginAndTheApiKeyAsPassword(): void
    {
        $pending = $this->sendPing(new LemlistConnector('secret-key'));

        self::assertSame('Basic '.base64_encode(':secret-key'), $pending->headers()->get('Authorization'));
    }

    public function testItTargetsTheLemlistApi(): void
    {
        $pending = $this->sendPing(new LemlistConnector('secret-key'));

        self::assertSame('https://api.lemlist.com/api/ping', $pending->getUrl());
    }

    public function testItIdentifiesItself(): void
    {
        $pending = $this->sendPing(new LemlistConnector('secret-key'));

        self::assertSame('noneo-sdk-lemlist/'.Lemlist::VERSION, $pending->headers()->get('User-Agent'));
    }

    public function testItNeverFollowsRedirects(): void
    {
        $pending = $this->sendPing(new LemlistConnector('secret-key'));

        self::assertFalse($pending->config()->get(RequestOptions::ALLOW_REDIRECTS));
    }

    public function testItAppliesDefaultTimeouts(): void
    {
        $pending = $this->sendPing(new LemlistConnector('secret-key'));

        self::assertSame(60.0, $pending->config()->get(RequestOptions::TIMEOUT));
        self::assertSame(10.0, $pending->config()->get(RequestOptions::CONNECT_TIMEOUT));
    }

    public function testTimeoutsCanBeOverridden(): void
    {
        $pending = $this->sendPing(new LemlistConnector('secret-key', requestTimeout: 5.0, connectTimeout: 2.0));

        self::assertSame(5.0, $pending->config()->get(RequestOptions::TIMEOUT));
        self::assertSame(2.0, $pending->config()->get(RequestOptions::CONNECT_TIMEOUT));
    }

    private function sendPing(LemlistConnector $connector): PendingRequest
    {
        $mockClient = new MockClient([MockResponse::make(['ok' => true])]);
        $connector->withMockClient($mockClient);
        $connector->send(new GetPing());

        $pending = $mockClient->getLastPendingRequest();
        self::assertInstanceOf(PendingRequest::class, $pending);

        return $pending;
    }
}
