<?php

namespace LaVoz\Tinypass\Endpoint;

use LaVoz\Tinypass\Client;

/**
 * Class ConversionEndpoint
 *
 * @package LaVoz\Tinypass\Endpoint
 */
class ConversionEndpoint
{

    /**
     * @var \LaVoz\Tinypass\Client
     */
    private $client;

    /**
     * ConversionEndpoint constructor.
     *
     * @param \LaVoz\Tinypass\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    /**
     * @param $access_id
     *
     * @return mixed
     */
    public function get($access_id)
    {
        return $this->client->call('/publisher/conversion/get', compact('access_id'));
    }

}