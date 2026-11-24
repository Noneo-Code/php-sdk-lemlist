<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests\Resource;

use Noneo\Sdk\Lemlist\Lemlist;
use Noneo\Sdk\Lemlist\Testing\MockLemlist;
use Noneo\Sdk\Lemlist\Tests\Support\SdkTestCase;
use Saloon\Data\MultipartValue;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

/**
 * Comportements de bout en bout du code généré, sur quelques endpoints
 * représentatifs ; la couverture exhaustive est dans `SpecConformityTest`.
 */
final class ResourcesTest extends SdkTestCase
{
    public function testAListOfNamedSchemasBecomesAListOfDtos(): void
    {
        $mock = MockLemlist::create([
            'GET /campaigns' => MockLemlist::json([
                ['_id' => 'cam_1', 'name' => 'Lancement'],
                ['_id' => 'cam_2', 'name' => 'Relance'],
            ]),
        ]);

        $campaigns = $mock->lemlist()->campaigns()->getManyCampaigns(limit: 50, status: 'running');

        self::assertCount(2, $campaigns);
        self::assertSame('cam_1', $campaigns[0]->_id);
        self::assertSame('Relance', $campaigns[1]->name);
        self::assertSame(['limit' => 50, 'status' => 'running'], $mock->requests()[0]->query);
    }

    public function testAnAnonymousResponseIsReturnedAsADecodedArray(): void
    {
        $mock = MockLemlist::create([
            'GET /campaigns/cam_1/leads/' => MockLemlist::json([['_id' => 'lea_1', 'state' => 'emailsSent']]),
        ]);

        $leads = $mock->lemlist()->leads()->getCampaignLeads('cam_1');

        self::assertSame([['_id' => 'lea_1', 'state' => 'emailsSent']], $leads);
    }

    public function testArgumentsLeftNullAreNotSent(): void
    {
        $mock = MockLemlist::create(['PATCH /campaigns/cam_1' => MockLemlist::json(['_id' => 'cam_1'])]);

        $mock->lemlist()->campaigns()->updateCampaign('cam_1', name: 'Nouveau nom');

        self::assertSame(['name' => 'Nouveau nom'], $mock->requests()[0]->body);
        self::assertSame([], $mock->requests()[0]->query);
    }

    public function testPathParametersAreUrlEncoded(): void
    {
        $mock = MockLemlist::create(['GET /leads/*' => MockLemlist::json([])]);

        $mock->lemlist()->leads()->getLeadByEmail('ada+test@example.com');

        self::assertSame('/leads/ada%2Btest%40example.com', $mock->requests()[0]->path);
    }

    public function testDatesAreSentInUtcIso8601(): void
    {
        $mock = MockLemlist::create(['GET /v2/campaigns/cam_1/stats' => MockLemlist::json([])]);

        $mock->lemlist()->campaigns()->getCampaignStats(
            campaignId: 'cam_1',
            startDate: new \DateTimeImmutable('2025-03-01T00:00:00+01:00'),
            endDate: '2025-03-31T23:59:59.000Z',
        );

        self::assertSame(
            ['startDate' => '2025-02-28T23:00:00.000Z', 'endDate' => '2025-03-31T23:59:59.000Z'],
            $mock->requests()[0]->query,
        );
    }

    public function testAFieldNamedLikeASaloonPropertyKeepsItsWireName(): void
    {
        $mock = MockLemlist::create(['POST /sequences/seq_1/steps' => MockLemlist::json([])]);

        $mock->lemlist()->sequences()->addStepToSequence('seq_1', type: 'api', method: 'POST');

        self::assertSame(['type' => 'api', 'method' => 'POST'], $mock->requests()[0]->body);
    }

    public function testAFileIsUploadedAsMultipart(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'lemlist-sdk-');
        self::assertIsString($path);
        file_put_contents($path, 'audio');

        try {
            $mockClient = new MockClient([MockResponse::make(['ok' => true])]);
            $lemlist = new Lemlist('secret-key');
            $lemlist->connector()->withMockClient($mockClient);

            $lemlist->leads()->uploadAudioForVoiceMessageStep(leadId: 'lea_1', stepId: 'stp_1', file: $path);

            $pending = $mockClient->getLastPendingRequest();
            self::assertNotNull($pending);
            self::assertSame(['leadId' => 'lea_1', 'stepId' => 'stp_1'], $pending->query()->all());

            $parts = $pending->body()?->all();
            self::assertIsArray($parts);
            self::assertCount(1, $parts);
            $part = reset($parts);
            self::assertInstanceOf(MultipartValue::class, $part);
            self::assertSame('file', $part->name);
            self::assertSame(basename($path), $part->filename);
            self::assertIsResource($part->value);
            self::assertSame('audio', stream_get_contents($part->value));
        } finally {
            unlink($path);
        }
    }

    public function testAMissingFileIsRefusedBeforeAnyRequest(): void
    {
        $mock = MockLemlist::create();

        try {
            $mock->lemlist()->leads()->uploadAudioForVoiceMessageStep(leadId: 'lea_1', stepId: 'stp_1', file: '/inexistant.mp3');
            self::fail('Une exception était attendue.');
        } catch (\InvalidArgumentException) {
            $mock->assertNothingSent();
        }
    }

    public function testAnUndocumentedResponseBodyIsReturnedRatherThanDropped(): void
    {
        $mock = MockLemlist::create(['POST /inbox/whatsapp' => MockLemlist::json(['ok' => true])]);

        $result = $mock->lemlist()->inbox()->sendWhatsAppMessage(
            sendUserId: 'usr_1',
            sendUserWhatsappAccountId: 'wha_1',
            contactId: 'ctc_1',
            leadId: 'lea_1',
            message: 'Bonjour',
        );

        self::assertSame(['ok' => true], $result);
    }

    public function testAnExportMayComeBackAsCsvOrJson(): void
    {
        $mock = MockLemlist::create([
            MockLemlist::text("email\nada@example.com\n"),
            MockLemlist::json([['email' => 'ada@example.com']]),
        ]);
        $lemlist = $mock->lemlist();

        self::assertSame("email\nada@example.com\n", $lemlist->campaigns()->exportCampaignLeads('cam_1', format: 'csv'));
        self::assertSame([['email' => 'ada@example.com']], $lemlist->campaigns()->exportCampaignLeads('cam_1', format: 'json'));
    }
}
