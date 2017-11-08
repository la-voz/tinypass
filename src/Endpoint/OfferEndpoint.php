<?php

namespace LaVoz\Tinypass\Endpoint;

use LaVoz\Tinypass\Client;

/**
 * Class OfferEndpoint
 * @package LaVoz\Tinypass\Endpoint
 */
class OfferEndpoint
{
    /**
     * @var Client
     */
    private $client;

    /**
     * OfferEndpoint constructor.
     *
     * @param \LaVoz\Tinypass\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $offer_id
     * @return mixed
     */
    public function get($offer_id)
    {
        return $this->client->call('/publisher/offer/get', compact('offer_id'));
    }
}