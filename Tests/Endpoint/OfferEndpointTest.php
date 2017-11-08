<?php

namespace LaVoz\Tinypass\Tests\Endpoint;

use LaVoz\Tinypass\Endpoint\OfferEndpoint;
use LaVoz\Tinypass\Exception\InvalidArgumentException;

class OfferEndpointTest extends EndpointTestCase
{
    public function test_offer_wrong_offer_id()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->getGuzzleClient()
            ->getConfig('handler')
            ->setHandler($this->mock_response('offer_wrong_offer_id.json'));

        $endpoint = new OfferEndpoint($this->client);

        $endpoint->get('wrong_offer_id');
    }

    public function test_offer_empty_offer_id()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->getGuzzleClient()
            ->getConfig('handler')
            ->setHandler($this->mock_response('offer_empty_offer_id.json'));

        $endpoint = new OfferEndpoint($this->client);

        $endpoint->get('');
    }

    public function test_offer_ok()
    {
        $this->client->getGuzzleClient()
            ->getConfig('handler')
            ->setHandler($this->mock_response('offer_ok.json'));

        $endpoint = new OfferEndpoint($this->client);

        $response = $endpoint->get('OFKG6I67H9KX');

        $this->assertEquals(0, $response->code);
    }
}
