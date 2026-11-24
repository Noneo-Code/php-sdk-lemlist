<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests\Http;

use Noneo\Sdk\Lemlist\Exception\BadRequestException;
use Noneo\Sdk\Lemlist\Exception\ClientException;
use Noneo\Sdk\Lemlist\Exception\ConflictException;
use Noneo\Sdk\Lemlist\Exception\ConnectionException;
use Noneo\Sdk\Lemlist\Exception\ForbiddenException;
use Noneo\Sdk\Lemlist\Exception\LemlistException;
use Noneo\Sdk\Lemlist\Exception\NotFoundException;
use Noneo\Sdk\Lemlist\Exception\RateLimitException;
use Noneo\Sdk\Lemlist\Exception\RedirectException;
use Noneo\Sdk\Lemlist\Exception\ServerException;
use Noneo\Sdk\Lemlist\Exception\UnauthorizedException;
use Noneo\Sdk\Lemlist\Exception\ValidationException;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Tests\Support\GetPing;
use Noneo\Sdk\Lemlist\Tests\Support\SdkTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

final class ErrorHandlingTest extends SdkTestCase
{
    /**
     * @param class-string<LemlistException> $expected
     */
    #[DataProvider('statuses')]
    public function testEachFailureStatusHasItsException(int $status, string $expected): void
    {
        try {
            $this->send(MockResponse::make(['error' => 'boom'], $status));
            self::fail('Une exception était attendue.');
        } catch (LemlistException $exception) {
            self::assertInstanceOf($expected, $exception);
            self::assertSame($status, $exception->status());
            self::assertSame('boom', $exception->getMessage());
        }
    }

    /**
     * @return iterable<string, array{int, class-string<LemlistException>}>
     */
    public static function statuses(): iterable
    {
        yield '302' => [302, RedirectException::class];
        yield '400' => [400, BadRequestException::class];
        yield '401' => [401, UnauthorizedException::class];
        yield '403' => [403, ForbiddenException::class];
        yield '404' => [404, NotFoundException::class];
        yield '409' => [409, ConflictException::class];
        yield '418' => [418, ClientException::class];
        yield '422' => [422, ValidationException::class];
        yield '429' => [429, RateLimitException::class];
        yield '503' => [503, ServerException::class];
    }

    public function testAPlainTextErrorBodyBecomesTheMessage(): void
    {
        try {
            $this->send(MockResponse::make('Invalid API key', 401));
            self::fail('Une exception était attendue.');
        } catch (UnauthorizedException $exception) {
            self::assertSame('Invalid API key', $exception->getMessage());
            self::assertSame('Invalid API key', $exception->responseBody());
        }
    }

    public function testAnErrorEnvelopeExposesItsCodeAndMessage(): void
    {
        try {
            $this->send(MockResponse::make(
                ['success' => false, 'error' => ['code' => 'PLAN_REQUIRED', 'message' => 'Upgrade your plan']],
                403,
            ));
            self::fail('Une exception était attendue.');
        } catch (ForbiddenException $exception) {
            self::assertSame('Upgrade your plan', $exception->getMessage());
            self::assertSame('PLAN_REQUIRED', $exception->errorCode());
            self::assertSame(['success' => false, 'code' => 'PLAN_REQUIRED'], $exception->details());
        }
    }

    public function testARateLimitExceptionExposesRetryAfterAndRateLimitHeaders(): void
    {
        try {
            $this->send(MockResponse::make('Too many requests', 429, [
                'Retry-After' => '2',
                'X-RateLimit-Remaining' => '0',
                'Set-Cookie' => 'session=secret',
            ]));
            self::fail('Une exception était attendue.');
        } catch (RateLimitException $exception) {
            self::assertSame(2, $exception->retryAfter());
            self::assertSame(['Retry-After' => '2', 'X-RateLimit-Remaining' => '0'], $exception->responseHeaders());
        }
    }

    public function testAnExceptionNeverCarriesTheApiKey(): void
    {
        try {
            $this->send(MockResponse::make(['error' => 'nope'], 401));
            self::fail('Une exception était attendue.');
        } catch (LemlistException $exception) {
            $state = self::ownState($exception);

            self::assertStringNotContainsString('secret-key', $state);
            self::assertStringNotContainsString(base64_encode(':secret-key'), $state);
        }
    }

    public function testANetworkFailureBecomesAConnectionExceptionWithoutLeakingTheRequest(): void
    {
        $failure = MockResponse::make()->throw(
            static fn (PendingRequest $pendingRequest): FatalRequestException => new FatalRequestException(
                new \RuntimeException('cURL error 6: Could not resolve host'),
                $pendingRequest,
            ),
        );

        try {
            $this->send($failure);
            self::fail('Une exception était attendue.');
        } catch (ConnectionException $exception) {
            self::assertSame('cURL error 6: Could not resolve host', $exception->getMessage());
            self::assertSame(0, $exception->status());
            self::assertNull($exception->getPrevious());
            self::assertStringNotContainsString(base64_encode(':secret-key'), self::ownState($exception));
        }
    }

    public function testASuccessfulResponseDoesNotThrow(): void
    {
        $this->send(MockResponse::make(['ok' => true], 201));

        $this->expectNotToPerformAssertions();
    }

    /**
     * Ce que l'exception retient par elle-même, hors trace d'appel : les
     * arguments d'une trace dépendent de `zend.exception_ignore_args`, pas du
     * SDK. Toute propriété objet y apparaîtrait avec son contenu.
     */
    private static function ownState(LemlistException $exception): string
    {
        $state = [];

        for ($class = new \ReflectionClass($exception); false !== $class && \Exception::class !== $class->getName(); $class = $class->getParentClass()) {
            foreach ($class->getProperties() as $property) {
                $state[$class->getName().'::'.$property->getName()] = $property->getValue($exception);
            }
        }

        return print_r($state, true).$exception->getMessage();
    }

    private function send(MockResponse $response): void
    {
        $connector = new LemlistConnector('secret-key', maxRetries: 0);
        $connector->withMockClient(new MockClient([$response]));
        $connector->send(new GetPing());
    }
}
