<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests\Support;

use Noneo\Sdk\Lemlist\Support\Cast;
use PHPUnit\Framework\TestCase;

final class CastTest extends TestCase
{
    public function testStringKeepsStringsAndStringifiesNumbers(): void
    {
        self::assertSame('abc', Cast::string('abc'));
        self::assertSame('42', Cast::string(42));
        self::assertNull(Cast::string(null));
        self::assertNull(Cast::string(['a']));
        self::assertNull(Cast::string(true));
    }

    public function testIntAcceptsIntegralValuesOnly(): void
    {
        self::assertSame(7, Cast::int(7));
        self::assertSame(7, Cast::int('7'));
        self::assertSame(7, Cast::int(7.0));
        self::assertNull(Cast::int(7.5));
        self::assertNull(Cast::int('abc'));
        self::assertNull(Cast::int(null));
    }

    public function testFloatAcceptsAnyNumber(): void
    {
        self::assertSame(1.5, Cast::float(1.5));
        self::assertSame(2.0, Cast::float(2));
        self::assertSame(0.25, Cast::float('0.25'));
        self::assertNull(Cast::float('abc'));
    }

    public function testBoolRejectsAnythingButBooleans(): void
    {
        self::assertTrue(Cast::bool(true));
        self::assertFalse(Cast::bool(false));
        self::assertNull(Cast::bool(1));
        self::assertNull(Cast::bool('true'));
    }

    public function testDateTimeParsesIsoStringsAndIgnoresGarbage(): void
    {
        $date = Cast::dateTime('2024-03-01T10:15:30.000Z');

        self::assertInstanceOf(\DateTimeImmutable::class, $date);
        self::assertSame('2024-03-01T10:15:30+00:00', $date->format(\DATE_ATOM));
        self::assertNull(Cast::dateTime('pas une date'));
        self::assertNull(Cast::dateTime(''));
        self::assertNull(Cast::dateTime(12));
    }

    public function testMapKeepsArraysOnly(): void
    {
        self::assertSame(['a' => 1], Cast::map(['a' => 1]));
        self::assertNull(Cast::map('a'));
    }

    public function testScalarListsDropUncastableItems(): void
    {
        self::assertSame(['a', '1'], Cast::strings(['a', 1, ['x']]));
        self::assertSame([1, 2], Cast::ints([1, '2', 'x']));
        self::assertSame([1.0, 2.5], Cast::floats([1, 2.5, null]));
        self::assertNull(Cast::strings('a'));
    }

    public function testObjectBuildsThroughTheFactory(): void
    {
        $factory = static fn (array $data): string => 'built:'.Cast::string($data['id'] ?? null);

        self::assertSame('built:x', Cast::object(['id' => 'x'], $factory));
        self::assertNull(Cast::object('x', $factory));
        self::assertNull(Cast::object(null, $factory));
    }

    public function testObjectsBuildsEachArrayItemAndSkipsTheRest(): void
    {
        $factory = static fn (array $data): string => 'built:'.Cast::string($data['id'] ?? null);

        self::assertSame(['built:a', 'built:b'], Cast::objects([['id' => 'a'], 'intrus', ['id' => 'b']], $factory));
        self::assertNull(Cast::objects(null, $factory));
    }
}
