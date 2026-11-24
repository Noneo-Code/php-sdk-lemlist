<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests\Support;

use Noneo\Sdk\Lemlist\Support\Payload;
use PHPUnit\Framework\TestCase;

final class PayloadTest extends TestCase
{
    public function testQueryDropsNullsAndSpellsBooleansOut(): void
    {
        self::assertSame(
            ['limit' => 10, 'verifyEmail' => 'true', 'findPhone' => 'false', 'search' => 'acme'],
            Payload::query(['limit' => 10, 'offset' => null, 'verifyEmail' => true, 'findPhone' => false, 'search' => 'acme']),
        );
    }

    public function testQueryFormatsDatesInUtc(): void
    {
        $date = new \DateTimeImmutable('2024-03-01T12:00:00+02:00');

        self::assertSame(
            ['startDate' => '2024-03-01T10:00:00.000Z'],
            Payload::query(['startDate' => $date]),
        );
    }

    public function testQueryKeepsListsSoTheyAreSentInBracketNotation(): void
    {
        $query = Payload::query(['type' => ['a', 'b'], 'flags' => [true]]);

        self::assertSame(['type' => ['a', 'b'], 'flags' => ['true']], $query);
        self::assertSame('type[0]=a&type[1]=b&flags[0]=true', urldecode(http_build_query($query)));
    }

    public function testBodyDropsNullsButKeepsFalseAndEmptyValues(): void
    {
        self::assertSame(
            ['name' => 'Acme', 'enabled' => false, 'labels' => [], 'count' => 0],
            Payload::body(['name' => 'Acme', 'emoji' => null, 'enabled' => false, 'labels' => [], 'count' => 0]),
        );
    }

    public function testBodyFormatsDatesAndLetsNamedFieldsWinOverAdditionalOnes(): void
    {
        $date = new \DateTimeImmutable('2024-03-01T10:00:00Z');

        self::assertSame(
            ['customVar' => 'x', 'email' => 'named@example.com', 'at' => '2024-03-01T10:00:00.000Z'],
            Payload::body(['email' => 'named@example.com', 'at' => $date], ['customVar' => 'x', 'email' => 'additional@example.com']),
        );
    }

    public function testFileOpensAReadableFile(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'lemlist-sdk-');
        self::assertIsString($path);
        file_put_contents($path, 'audio');

        try {
            $stream = Payload::file($path);

            self::assertSame('audio', stream_get_contents($stream));
        } finally {
            unlink($path);
        }
    }

    public function testFileRefusesAMissingPath(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Payload::file('/chemin/inexistant.mp3');
    }
}
