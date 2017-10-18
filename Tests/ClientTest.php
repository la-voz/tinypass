<?php

namespace LaVoz\Tinypass\Tests;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Response;
use LaVoz\Tinypass\Client;
use LaVoz\Tinypass\Endpoint\UserAccessEndpoint;
use LaVoz\Tinypass\Exception\HttpRequestException;
use LaVoz\Tinypass\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{

    /**
     * @dataProvider invalid_config_provider
     */
    public function test_invalid_client($config, $expected_message)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($expected_message);
        (new Client($config));
    }

    public function test_valid_client()
    {
        $client_debug = new Client([
            'sandbox' => true,
            'api_token' => 'TOKEN',
            'aid' => '1',
            'method' => 'get',
        ]);
        $this->assertInstanceOf(GuzzleClient::class,
            $client_debug->getGuzzleClient());
        $this->assertEquals(Client::BASE_SANDBOX_URI,
            $client_debug->getGuzzleClient()->getConfig('base_uri'));

        $client = new Client([
            'api_token' => 'TOKEN',
            'method' => 'post',
            'aid' => '1',
        ]);
        $this->assertInstanceOf(GuzzleClient::class,
            $client->getGuzzleClient());
        $this->assertEquals(Client::BASE_URI,
            $client->getGuzzleClient()->getConfig('base_uri'));
        $this->assertInstanceOf(UserAccessEndpoint::class,
            $client->userAccess());
    }

    public function test_endpoint_not_found()
    {
        $this->expectException(HttpRequestException::class);
        $this->expectExceptionMessage('Endpoint does not exist: /api/v3');
        $client = new Client(['api_token' => 'TOKEN', 'aid' => 'AID']);
        $client->getGuzzleClient()->getConfig('handler')
            ->setHandler($this->mock_response('endpoint_not_found.json'));
        $client->call('/');
    }

    public function test_wrong_api_token()
    {
        $this->expectException(HttpRequestException::class);
        $this->expectExceptionMessage('Unable to find user for given API token');
        $client = new Client(['api_token' => 'TOKEN', 'aid' => 'AID']);
        $client->getGuzzleClient()->getConfig('handler')
            ->setHandler($this->mock_response('wrong_api_token.json'));
        $client->call('/access/list');
    }

    public function invalid_config_provider()
    {
        return [
            [[], 'Missing API token.'],
            [
                ['api_token' => 'TOKEN', 'method' => 'wrong'],
                'Method can only be `post` or `get`.',
            ],
            [
                ['api_token' => 'TOKEN', 'method' => 'get'],
                'Missing Application ID.',
            ],
        ];
    }

    protected function mock_response($file)
    {
        return new MockHandler([
            new Response(200, [],
                Psr7\stream_for($this->get_file_contents($file))),
        ]);
    }

    protected function get_file_contents($file_name)
    {
        return file_get_contents(__DIR__ . '/examples/' . $file_name);
    }

}
