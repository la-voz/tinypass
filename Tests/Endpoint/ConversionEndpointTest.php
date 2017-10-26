<?php

namespace LaVoz\Tinypass\Tests\Endpoint;

use LaVoz\Tinypass\Endpoint\ConversionEndpoint;
use LaVoz\Tinypass\Exception\InvalidArgumentException;

class ConversionEndpointTest extends EndpointTestCase
{
    public function test_conversion_wrong_access_id()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->getGuzzleClient()
            ->getConfig('handler')
            ->setHandler($this->mock_response('conversion_wrong_access_id.json'));

        $endpoint = new ConversionEndpoint($this->client);

        $endpoint->get('wrong_access_id');
    }

    public function test_conversion_empty_access_id()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->getGuzzleClient()
            ->getConfig('handler')
            ->setHandler($this->mock_response('conversion_empty_access_id.json'));

        $endpoint = new ConversionEndpoint($this->client);

        $endpoint->get('');
    }

    public function test_conversion_ok()
    {
        $this->client->getGuzzleClient()
            ->getConfig('handler')
            ->setHandler($this->mock_response('conversion_ok.json'));

        $endpoint = new ConversionEndpoint($this->client);

        $response = $endpoint->get('ACCESS_ID');

        $this->assertEquals(0, $response->code);
    }
}
