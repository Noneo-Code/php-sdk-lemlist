<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests\Dto;

use Noneo\Sdk\Lemlist\Dto\CampaignCreatorDto;
use Noneo\Sdk\Lemlist\Dto\CampaignDto;
use Noneo\Sdk\Lemlist\Dto\ScheduleDto;
use Noneo\Sdk\Lemlist\Dto\ScheduleListResponseDto;
use PHPUnit\Framework\TestCase;

final class DtoTest extends TestCase
{
    public function testADocumentedPayloadIsMappedToTypedProperties(): void
    {
        $campaign = CampaignDto::fromArray([
            '_id' => 'cam_4HrZbi8xsez4QlrnL',
            'name' => 'Product Launch Campaign',
            'labels' => ['CRM', 'Q1'],
            'createdAt' => '2025-02-20T14:45:54.230Z',
            'status' => 'running',
            'hasError' => true,
            'errors' => ['Your campaign does not have sender.'],
            'creator' => ['userId' => 'usr_1', 'userEmail' => 'ada@example.com'],
        ]);

        self::assertSame('cam_4HrZbi8xsez4QlrnL', $campaign->_id);
        self::assertSame('Product Launch Campaign', $campaign->name);
        self::assertSame(['CRM', 'Q1'], $campaign->labels);
        self::assertSame('2025-02-20T14:45:54+00:00', $campaign->createdAt?->format(\DATE_ATOM));
        self::assertSame('running', $campaign->status);
        self::assertTrue($campaign->hasError);
        self::assertSame(['Your campaign does not have sender.'], $campaign->errors);
        self::assertInstanceOf(CampaignCreatorDto::class, $campaign->creator);
    }

    public function testAnAbsentFieldIsNull(): void
    {
        $campaign = CampaignDto::fromArray([]);

        self::assertNull($campaign->_id);
        self::assertNull($campaign->createdAt);
        self::assertNull($campaign->labels);
        self::assertNull($campaign->creator);
        self::assertSame([], $campaign->raw);
    }

    public function testAnUnexpectedTypeBecomesNullWithoutThrowing(): void
    {
        $payload = ['name' => ['pas', 'une', 'chaîne'], 'hasError' => 'oui', 'createdAt' => 'jamais', 'creator' => 'usr_1'];

        $campaign = CampaignDto::fromArray($payload);

        self::assertNull($campaign->name);
        self::assertNull($campaign->hasError);
        self::assertNull($campaign->createdAt);
        self::assertNull($campaign->creator);
        self::assertSame($payload, $campaign->raw);
    }

    public function testUndocumentedFieldsStayReachableThroughRaw(): void
    {
        $campaign = CampaignDto::fromArray(['_id' => 'cam_1', 'champInconnu' => 42]);

        self::assertSame(42, $campaign->raw['champInconnu']);
    }

    public function testNestedListsAndObjectsBecomeDtos(): void
    {
        $response = ScheduleListResponseDto::fromArray([
            'schedules' => [
                ['_id' => 'skd_1', 'name' => 'Semaine', 'secondsToWait' => 1200, 'weekdays' => [1, 2, 3], 'public' => false],
                ['_id' => 'skd_2', 'name' => 'Week-end', 'weekdays' => [6, 7]],
            ],
            'pagination' => ['totalRecords' => 2, 'currentPage' => 1],
        ]);

        self::assertNotNull($response->schedules);
        self::assertCount(2, $response->schedules);
        self::assertContainsOnlyInstancesOf(ScheduleDto::class, $response->schedules);
        self::assertSame('Semaine', $response->schedules[0]->name);
        self::assertSame(1200, $response->schedules[0]->secondsToWait);
        self::assertSame([1, 2, 3], $response->schedules[0]->weekdays);
        self::assertFalse($response->schedules[0]->public);
        self::assertSame(2, $response->pagination?->totalRecords);
    }

    public function testADtoCanBeBuiltByNameForFixtures(): void
    {
        $campaign = new CampaignDto(name: 'Fixture');

        self::assertSame('Fixture', $campaign->name);
        self::assertNull($campaign->_id);
        self::assertSame([], $campaign->raw);
    }
}
