<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests\Generator;

use Noneo\Sdk\Lemlist\Generator\Naming;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class NamingTest extends TestCase
{
    #[DataProvider('pascalCases')]
    public function testPascalTurnsASummaryIntoAClassName(string $input, string $expected): void
    {
        self::assertSame($expected, Naming::pascal($input));
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function pascalCases(): iterable
    {
        yield 'plain summary' => ['Get Many Campaigns', 'GetManyCampaigns'];
        yield 'punctuation' => ['Search & Connect Contacts in the CRM', 'SearchConnectContactsInTheCrm'];
        yield 'single letters' => ['Create A/B Test Variant', 'CreateABTestVariant'];
        yield 'operationId' => ['listLinkedinProfileViewsMembers', 'ListLinkedinProfileViewsMembers'];
        yield 'plural acronym' => ['CRMs', 'Crms'];
        yield 'hyphen' => ['Self-recovery', 'SelfRecovery'];
        yield 'lowercase tag' => ['warmup', 'Warmup'];
        yield 'acronym inside' => ['Send SMS Message', 'SendSmsMessage'];
        yield 'trailing acronym' => ['Get Lead by Email or ID', 'GetLeadByEmailOrId'];
        yield 'mixed case kept' => ['Send LinkedIn Message', 'SendLinkedInMessage'];
        yield 'property name' => ['_id', 'Id'];
    }

    public function testCamelLowersTheFirstLetterOnly(): void
    {
        self::assertSame('peopleDatabase', Naming::camel('PeopleDatabase'));
        self::assertSame('crms', Naming::camel('Crms'));
    }

    public function testDescriptionIsFlattenedToOneSentenceWithoutFinalDot(): void
    {
        self::assertSame(
            'Number of items to return',
            Naming::description("Number of items\n to return.  \nDefaults to 100."),
        );
    }

    public function testDescriptionCannotCloseTheDocblock(): void
    {
        self::assertSame('Path like a/* /b', Naming::description('Path like a/*/b'));
    }

    public function testDescriptionIsTruncated(): void
    {
        $description = Naming::description(str_repeat('word ', 80));

        self::assertSame(160, mb_strlen($description));
        self::assertStringEndsWith('…', $description);
    }

    public function testSensitiveNamesAreDetected(): void
    {
        self::assertTrue(Naming::isSensitive('smtpPassword'));
        self::assertTrue(Naming::isSensitive('apiKey'));
        self::assertTrue(Naming::isSensitive('accessToken'));
        self::assertFalse(Naming::isSensitive('campaignId'));
    }
}
