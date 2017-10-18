<?php

namespace LaVoz\Tinypass\Endpoint;

use LaVoz\Tinypass\Exception\InvalidArgumentException;

/**
 * Class UserAccessEndpoint
 *
 * @package LaVoz\Tinypass
 */
class UserAccessEndpoint
{
    /**
     * @var \LaVoz\Tinypass\Client
     */
    private $client;

    /**
     * UserAccessEndpoint constructor.
     *
     * @param \LaVoz\Tinypass\Client $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @param $rid
     * @param array $user
     *
     * @return mixed
     */
    public function grant($rid, $user = [])
    {
        $params = ['rid' => $rid];
        if (!empty($user['uid'])) {
            $params['uid'] = $user['uid'];
        }
        if (!empty($user['emails'])) {
            $params['emails'] = $user['emails'];
        }
        return $this->client->call('/publisher/user/access/grant', $params);
    }

}
