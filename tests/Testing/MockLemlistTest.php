<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests\Testing;

use Noneo\Sdk\Lemlist\Exception\NotFoundException;
use Noneo\Sdk\Lemlist\Exception\UnauthorizedException;
use Noneo\Sdk\Lemlist\Testing\MockLemlist;
use Noneo\Sdk\Lemlist\Testing\UnexpectedRequestException;
use Noneo\Sdk\Lemlist\Tests\Support\SdkTestCase;
use PHPUnit\Framework\AssertionFailedError;

final class MockLemlistTest extends SdkTestCase
{
    public function testAResponseIsMatchedByMethodAndPath(): void
    {
        $mock = MockLemlist::create([
            'GET /team' => MockLemlist::json(['_id' => 'tea_1', 'name' => 'Noneo']),
        ]);

        $team = $mock->lemlist()->team()->getTeam();

        self::assertSame('Noneo', $team->name);
        $mock->assertSent('GET', '/team');
    }

    public function testAPathMayUseWildcards(): void
    {
        $mock = MockLemlist::create([
            'POST /campaigns/*/pause' => MockLemlist::json(['_id' => 'cam_1', 'state' => 'paused']),
        ]);

        $mock->lemlist()->campaigns()->pauseCampaign('cam_1');

        $mock->assertSent('POST', '/campaigns/cam_1/pause');
        $mock->assertSent('POST', '/campaigns/*/pause');
    }

    public function testResponsesWithoutKeysAreServedInOrder(): void
    {
        $mock = MockLemlist::create([
            MockLemlist::json(['name' => 'Première']),
            MockLemlist::json(['name' => 'Seconde']),
        ]);
        $lemlist = $mock->lemlist();

        self::assertSame('Première', $lemlist->team()->getTeam()->name);
        self::assertSame('Seconde', $lemlist->team()->getTeam()->name);
    }

    public function testAnErrorResponseRaisesTheSdkException(): void
    {
        $mock = MockLemlist::create([
            'GET /campaigns/*' => MockLemlist::error(404, ['error' => 'Campaign not found']),
        ]);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Campaign not found');

        $mock->lemlist()->campaigns()->getCampaign('cam_inconnue');
    }

    public function testAnErrorMayCarryAPlainTextBody(): void
    {
        $mock = MockLemlist::create(['GET /team' => MockLemlist::error(401, 'Invalid API key')]);

        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Invalid API key');

        $mock->lemlist()->team()->getTeam();
    }

    public function testATextResponseIsReturnedAsIs(): void
    {
        $mock = MockLemlist::create([
            'GET /contacts/export' => MockLemlist::text("email\nada@example.com\n"),
        ]);

        self::assertSame("email\nada@example.com\n", $mock->lemlist()->contacts()->exportContactList('all'));
    }

    public function testARequestWithoutAMatchingResponseIsRefused(): void
    {
        $mock = MockLemlist::create(['GET /team' => MockLemlist::json([])]);

        $this->expectException(UnexpectedRequestException::class);
        $this->expectExceptionMessage('GET /schedules');

        $mock->lemlist()->schedules()->getManySchedules();
    }

    public function testAnExhaustedQueueRefusesTheNextRequest(): void
    {
        $mock = MockLemlist::create([MockLemlist::json([])]);
        $lemlist = $mock->lemlist();
        $lemlist->team()->getTeam();

        $this->expectException(UnexpectedRequestException::class);

        $lemlist->team()->getTeam();
    }

    public function testSequentialAndKeyedResponsesCannotBeMixed(): void
    {
        $this->expectException(\LogicException::class);

        MockLemlist::create([MockLemlist::json([]), 'GET /team' => MockLemlist::json([])]);
    }

    public function testAKeyMustNameAMethodAndAPath(): void
    {
        $this->expectException(\LogicException::class);

        MockLemlist::create(['/team' => MockLemlist::json([])]);
    }

    public function testAssertSentFailsWhenNothingMatches(): void
    {
        $mock = MockLemlist::create(['GET /team' => MockLemlist::json([])]);
        $mock->lemlist()->team()->getTeam();

        $this->expectException(AssertionFailedError::class);

        $mock->assertSent('DELETE', '/team');
    }

    public function testAssertNotSentAndAssertNothingSent(): void
    {
        $mock = MockLemlist::create(['GET /team' => MockLemlist::json([])]);

        $mock->assertNothingSent();
        $mock->assertNotSent('GET', '/team');

        $mock->lemlist()->team()->getTeam();

        $this->expectException(AssertionFailedError::class);

        $mock->assertNotSent('GET', '/team');
    }

    public function testAssertNothingElseSentRevealsUndescribedCalls(): void
    {
        $mock = MockLemlist::create([
            'GET /team' => MockLemlist::json([]),
            'GET /team/credits' => MockLemlist::json([]),
        ]);
        $lemlist = $mock->lemlist();
        $lemlist->team()->getTeam();
        $lemlist->team()->getTeamCredits();

        $mock->assertSent('GET', '/team');

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage('GET /team/credits');

        $mock->assertNothingElseSent();
    }

    public function testRecordedRequestsExposeQueryAndBody(): void
    {
        $mock = MockLemlist::create([
            'POST /campaigns/cam_1/leads/' => MockLemlist::json(['_id' => 'lea_1']),
        ]);

        $mock->lemlist()->leads()->createLeadInCampaign(
            campaignId: 'cam_1',
            email: 'ada@example.com',
            deduplicate: true,
            additional: ['favoriteColor' => 'bleu'],
        );

        $requests = $mock->requests();
        self::assertCount(1, $requests);
        self::assertSame('POST', $requests[0]->method);
        self::assertSame('/campaigns/cam_1/leads/', $requests[0]->path);
        self::assertSame(['deduplicate' => 'true'], $requests[0]->query);
        self::assertSame(['favoriteColor' => 'bleu', 'email' => 'ada@example.com'], $requests[0]->body);
    }

    public function testTheMockNeitherThrottlesNorRetries(): void
    {
        $mock = MockLemlist::create(['GET /team' => MockLemlist::error(429, 'Too many requests')]);
        $lemlist = $mock->lemlist();
        $start = microtime(true);

        for ($i = 0; $i < 30; ++$i) {
            try {
                $lemlist->team()->getTeam();
            } catch (\Throwable) {
            }
        }

        self::assertCount(30, $mock->requests());
        self::assertLessThan(1.0, microtime(true) - $start);
    }
}
