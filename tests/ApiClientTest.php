<?php

namespace Tests\SendCloud;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Imbue\SendCloud\SendCloudApiClient;

class ApiClientTest extends TestCase
{
    /** @var ClientInterface */
    private $guzzleClient;
    /** @var SendCloudApiClient */
    private $sendCloudApiClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->guzzleClient = $this->createMock(Client::class);
        $this->sendCloudApiClient = new SendCloudApiClient($this->guzzleClient);
        $this->sendCloudApiClient->setApiAuth('test_api_key', 'test_api_secret');
    }

    public function testPerformHttpCallReturnsBodyAsObject()
    {
        $response = new Response(200, [], '{"object": "parcel"}');

        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($response);

        $parsedResponse = $this->sendCloudApiClient->performHttpCall('GET', '');

        $this->assertEquals(
            (object)['object' => 'parcel'],
            $parsedResponse
        );
    }
}
