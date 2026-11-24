<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests\Pagination;

use Noneo\Sdk\Lemlist\Pagination\Paginator;
use PHPUnit\Framework\TestCase;

final class PaginatorTest extends TestCase
{
    public function testOffsetWalksUntilAShortPage(): void
    {
        $calls = [];
        $items = Paginator::offset(function (int $offset, int $limit) use (&$calls): array {
            $calls[] = [$offset, $limit];

            return array_slice(['a', 'b', 'c', 'd', 'e'], $offset, $limit);
        }, limit: 2);

        self::assertSame(['a', 'b', 'c', 'd', 'e'], iterator_to_array($items, false));
        self::assertSame([[0, 2], [2, 2], [4, 2]], $calls);
    }

    public function testOffsetStopsOnAnEmptyPageWhenTheTotalIsAMultipleOfTheLimit(): void
    {
        $calls = 0;
        $items = Paginator::offset(function (int $offset, int $limit) use (&$calls): array {
            ++$calls;

            return array_slice(['a', 'b'], $offset, $limit);
        }, limit: 2);

        self::assertSame(['a', 'b'], iterator_to_array($items, false));
        self::assertSame(2, $calls);
    }

    public function testPageStartsAtTheGivenFirstPage(): void
    {
        $pages = [1 => ['a', 'b'], 2 => ['c']];
        $seen = [];
        $items = Paginator::page(function (int $page, int $limit) use ($pages, &$seen): array {
            $seen[] = $page;

            return $pages[$page] ?? [];
        }, limit: 2);

        self::assertSame(['a', 'b', 'c'], iterator_to_array($items, false));
        self::assertSame([1, 2], $seen);
    }

    public function testNothingIsFetchedBeforeIteration(): void
    {
        $calls = 0;
        Paginator::offset(function () use (&$calls): array {
            ++$calls;

            return [];
        });

        self::assertSame(0, $calls);
    }

    public function testARejectedLimitNeverReachesTheApi(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        iterator_to_array(Paginator::offset(static fn (): array => [], limit: 0));
    }
}
