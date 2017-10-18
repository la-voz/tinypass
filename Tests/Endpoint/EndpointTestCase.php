<?php

namespace LaVoz\Tinypass\Tests\Endpoint;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Response;
use LaVoz\Tinypass\Client;
use PHPUnit\Framework\TestCase;

class EndpointTestCase extends TestCase
{

    protected $client;

    protected function setUp()
    {
        $this->client = new Client([
            'sandbox' => false,
            'api_token' => getenv('API_TOKEN'),
            'aid' => getenv('APPLICATION_ID'),
        ]);
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