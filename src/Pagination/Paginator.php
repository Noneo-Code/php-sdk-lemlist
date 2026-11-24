<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Pagination;

/**
 * Parcours paresseux d'une collection paginée. Les endpoints lemlist ne
 * partagent ni leurs paramètres (`offset`, `page`, `skip`) ni la forme de leur
 * réponse (tableau nu, `data`, `results`…) : le paginateur ne devine donc
 * rien. On lui fournit une fonction qui va chercher une page et en rend les
 * items ; il s'arrête à la première page incomplète.
 *
 * ```php
 * $campaigns = Paginator::offset(
 *     fn (int $offset, int $limit) => $lemlist->campaigns()->getManyCampaigns(offset: $offset, limit: $limit),
 * );
 * ```
 */
final class Paginator
{
    public const int DEFAULT_LIMIT = 100;

    /**
     * Pour les endpoints paginés par `offset` (ou `skip`) et `limit`.
     *
     * @template T
     *
     * @param callable(int $offset, int $limit): iterable<T> $fetch
     *
     * @return \Generator<int, T>
     */
    public static function offset(callable $fetch, int $limit = self::DEFAULT_LIMIT): \Generator
    {
        self::assertValidLimit($limit);

        $offset = 0;

        do {
            $count = 0;

            foreach ($fetch($offset, $limit) as $item) {
                ++$count;

                yield $item;
            }

            $offset += $limit;
        } while ($count >= $limit);
    }

    /**
     * Pour les endpoints paginés par `page` et `limit`.
     *
     * @template T
     *
     * @param callable(int $page, int $limit): iterable<T> $fetch
     *
     * @return \Generator<int, T>
     */
    public static function page(callable $fetch, int $limit = self::DEFAULT_LIMIT, int $firstPage = 1): \Generator
    {
        self::assertValidLimit($limit);

        $page = $firstPage;

        do {
            $count = 0;

            foreach ($fetch($page, $limit) as $item) {
                ++$count;

                yield $item;
            }

            ++$page;
        } while ($count >= $limit);
    }

    private static function assertValidLimit(int $limit): void
    {
        if ($limit < 1) {
            throw new \InvalidArgumentException('La taille de page doit être strictement positive.');
        }
    }
}
