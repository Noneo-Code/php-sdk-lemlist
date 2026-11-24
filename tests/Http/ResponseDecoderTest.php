<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests\Http;

use Noneo\Sdk\Lemlist\Exception\UnexpectedResponseException;
use Noneo\Sdk\Lemlist\Http\Connector\LemlistConnector;
use Noneo\Sdk\Lemlist\Http\Connector\ResponseDecoder;
use Noneo\Sdk\Lemlist\Tests\Support\GetPing;
use Noneo\Sdk\Lemlist\Tests\Support\SdkTestCase;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Response;

final class ResponseDecoderTest extends SdkTestCase
{
    public function testObjectReturnsTheDecodedBody(): void
    {
        self::assertSame(['_id' => 'cam_1'], ResponseDecoder::object($this->response(['_id' => 'cam_1'])));
    }

    public function testObjectTreatsAnEmptyBodyAsAnEmptyObject(): void
    {
        self::assertSame([], ResponseDecoder::object($this->response('')));
    }

    public function testObjectRejectsABodyThatIsNotJson(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        ResponseDecoder::object($this->response('<html>oops</html>'));
    }

    public function testObjectRejectsAJsonScalar(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        ResponseDecoder::object($this->response('"ok"'));
    }

    public function testItemsKeepsOnlyTheObjectsOfAList(): void
    {
        self::assertSame(
            [['_id' => 'a'], ['_id' => 'b']],
            ResponseDecoder::items($this->response([['_id' => 'a'], 'intrus', ['_id' => 'b']])),
        );
    }

    public function testItemsUnwrapsAListThatCameInAnEnvelope(): void
    {
        self::assertSame(
            [['_id' => 'a'], ['_id' => 'b']],
            ResponseDecoder::items($this->response([
                'campaigns' => [['_id' => 'a'], ['_id' => 'b']],
                'pagination' => ['totalRecords' => 2, 'currentPage' => 1],
            ])),
        );
    }

    public function testItemsRefusesAnObjectItCannotReadAsAList(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        ResponseDecoder::items($this->response(['_id' => 'cam_1', 'name' => 'Une seule campagne']));
    }

    public function testValueReturnsWhateverJsonWasSent(): void
    {
        self::assertTrue(ResponseDecoder::value($this->response('true')));
        self::assertSame(['a' => 1], ResponseDecoder::value($this->response(['a' => 1])));
        self::assertNull(ResponseDecoder::value($this->response('')));
    }

    public function testValueFallsBackToTheRawTextWhenTheBodyIsNotJson(): void
    {
        self::assertSame('OK', ResponseDecoder::value($this->response('OK')));
    }

    public function testTextReturnsTheRawBody(): void
    {
        self::assertSame("email\nada@example.com\n", ResponseDecoder::text($this->response("email\nada@example.com\n")));
    }

    /**
     * @param array<array-key, mixed>|string $body
     */
    private function response(array|string $body): Response
    {
        $connector = new LemlistConnector('secret-key');
        $connector->withMockClient(new MockClient([MockResponse::make($body)]));

        return $connector->send(new GetPing());
    }
}
