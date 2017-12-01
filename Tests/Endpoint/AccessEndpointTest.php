<?php

namespace LaVoz\Tinypass\Tests\Endpoint;

use LaVoz\Tinypass\Endpoint\AccessEndpoint;

class AccessEndpointTest extends EndpointTestCase
{
    public function test_access_list_ok()
    {
        $this->client->getGuzzleClient()
            ->getConfig('handler')
            ->setHandler($this->mock_response('access_list_ok.json'));

        $endpoint = new AccessEndpoint($this->client);

        $response = $endpoint->list(0, 100, 'O4ww9_j7uqCrci3RuSjF-AM2wE-M5jMDYTKlnwRHR2QbJcHMB9RflwcpKkoBROL9K4NfV0BWY3TvAJYUwFEKbkBpq4VSNyG8mCmVhxCXd3MaSQmQSvpuWzeOKSI-49YdBx24mkm1KbqmjUMvPpDJV9TNHFu1Op-0cVZaQmLM6lx-ihikQmLxH_C8UydlQZKMau77I4r8DzOKVeRFfI1r1w~~~CCZ26KicUqvcG3A0bGRhAryGXv--FSwbymJgsCKVt54');

        $this->assertEquals(0, $response->code);
    }
}
