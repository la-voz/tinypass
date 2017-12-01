<?php

namespace LaVoz\Tinypass\Endpoint;

use LaVoz\Tinypass\Client;

/**
 * Class AccessEndpoint
 *
 * @package LaVoz\Tinypass\Endpoint
 */
class AccessEndpoint
{

    /**
     * @var \LaVoz\Tinypass\Client
     */
    private $client;

    /**
     * AccessEndpoint constructor.
     *
     * @param \LaVoz\Tinypass\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $resource_id
     * @param null $user_token
     * @param null $user_provider
     * @param null $user_ref
     * @return mixed
     */
    public function check($resource_id, $user_token = null, $user_provider = null, $user_ref = null)
    {
        $params = ['rid' => $resource_id];

        if (!empty($user_token)) {
            $params['user_token'] = $user_token;
        }

        if (!empty($user_provider)) {
            $params['user_provider'] = $user_provider;
        }

        if (!empty($user_ref)) {
            $params['user_ref'] = $user_ref;
        }

        return $this->client->call('/access/check', $params);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param null $user_ref
     * @param null $user_token
     * @param null $user_provider
     * @return mixed
     */
    public function list($offset = 0, $limit = 100, $user_ref = null, $user_token = null, $user_provider = null)
    {
        $params = [
            'offset' => $offset,
            'limit' => $limit
        ];

        if (!empty($user_ref)) {
            $params['user_ref'] = $user_ref;
        }

        if (!empty($user_token)) {
            $params['user_token'] = $user_token;
        }

        if (!empty($user_provider)) {
            $params['user_provider'] = $user_provider;
        }

        return $this->client->call('/access/list', $params);
    }
}