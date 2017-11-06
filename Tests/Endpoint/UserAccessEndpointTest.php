<?php

namespace LaVoz\Tinypass\Tests\Endpoint;

use LaVoz\Tinypass\Endpoint\UserAccessEndpoint;
use LaVoz\Tinypass\Exception\InvalidArgumentException;

class UserAccessEndpointTest extends EndpointTestCase
{

    public function test_grant_wrong_rid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->client->getGuzzleClient()->getConfig('handler')
            ->setHandler($this->mock_response('grant_wrong_rid.json'));
        $endpoint = new UserAccessEndpoint($this->client);
        $endpoint->grant('wrong_id');
    }

    public function test_grant_empty_email()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->client->getGuzzleClient()->getConfig('handler')
            ->setHandler($this->mock_response('grant_empty_email.json'));
        $endpoint = new UserAccessEndpoint($this->client);
        $endpoint->grant('RID');
    }

    public function test_grant_ok()
    {
        $this->client->getGuzzleClient()->getConfig('handler')
            ->setHandler($this->mock_response('grant_ok.json'));
        $endpoint = new UserAccessEndpoint($this->client);
        $response = $endpoint->grant('RID', ['emails' => 'test@test.com']);
        $this->assertEquals(0, $response->code);
    }

    public function test_revoke_empty_access_id()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->client->getGuzzleClient()->getConfig('handler')
            ->setHandler($this->mock_response('revoke_empty_access_id.json'));
        $endpoint = new UserAccessEndpoint($this->client);
        $endpoint->revoke('');
    }

    public function test_revoke_wrong_access_id()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->client->getGuzzleClient()->getConfig('handler')
            ->setHandler($this->mock_response('revoke_wrong_access_id.json'));
        $endpoint = new UserAccessEndpoint($this->client);
        $endpoint->revoke('wrong_id');
    }

    public function test_revoke_ok()
    {
        $endpoint = new UserAccessEndpoint($this->client);
        $this->client->getGuzzleClient()->getConfig('handler')
            ->setHandler($this->mock_response('revoke_ok.json'));
        $response = $endpoint->revoke('ACCESS_ID');
        $this->assertEquals(0, $response->code);
    }

}
