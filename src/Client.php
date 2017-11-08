<?php

namespace LaVoz\Tinypass;

use GuzzleHttp\Client as GuzzleClient;
use LaVoz\Tinypass\Endpoint\ConversionEndpoint;
use LaVoz\Tinypass\Endpoint\OfferEndpoint;
use LaVoz\Tinypass\Endpoint\UserAccessEndpoint;
use LaVoz\Tinypass\Exception\{
    HttpRequestException,
    InvalidArgumentException
};

/**
 * Class Client
 *
 * @package LaVoz\Tinypass
 */
class Client
{

    /**
     * Base Sandbox URI
     */
    const BASE_SANDBOX_URI = 'https://sandbox.tinypass.com';

    /**
     * Base Sandbox URI
     */
    const BASE_URI = 'https://api.tinypass.com';

    /**
     * @var \GuzzleHttp\Client
     */
    private $guzzleClient;

    /**
     * Client constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $defaults = ['sandbox' => false, 'method' => 'post'];

        if (!empty($config['method'])) {
            if (!in_array($config['method'], ['post', 'get'])) {
                throw new InvalidArgumentException('Method can only be `post` or `get`.');
            }
        }

        if (empty($config['api_token'])) {
            throw new InvalidArgumentException('Missing API token.');
        }

        if (empty($config['aid'])) {
            throw new InvalidArgumentException('Missing Application ID.');
        }

        $config = array_merge($defaults, $config);
        $config['base_uri'] =
            $config['sandbox'] ? self::BASE_SANDBOX_URI : self::BASE_URI;
        $this->guzzleClient = new GuzzleClient($config);
    }

    /**
     * Get Guzzle Client
     *
     * @return \GuzzleHttp\Client
     */
    public function getGuzzleClient(): GuzzleClient
    {
        return $this->guzzleClient;
    }

    /**
     * @param string $path
     * @param array $params
     *
     * @return mixed
     * @throws \LaVoz\Tinypass\Exception\HttpRequestException
     */
    public function call($path = '', $params = [])
    {
        $default_params = [
            'api_token' => $this->getGuzzleClient()->getConfig('api_token'),
            'aid' => $this->getGuzzleClient()->getConfig('aid'),
        ];

        $params = array_merge($default_params, $params);

        if ($this->getGuzzleClient()->getConfig('method') === 'post') {
            $response = $this->getGuzzleClient()->post('/api/v3' . $path, [
                'form_params' => $params,
            ]);
        } else {
            $response = $this->getGuzzleClient()->get('/api/v3' . $path, [
                'query' => $params,
            ]);
        }
        $data = json_decode($response->getBody()->getContents());

        switch ($data->code) {
            case 401:
            case 404:
                throw new HttpRequestException($data->message);
                break;
            case 400:
            case 805:
            case 5001:
            case 5003:
                throw new InvalidArgumentException($data->message);
                break;
        }

        return $data;
    }

    /**
     * @return \LaVoz\Tinypass\Endpoint\UserAccessEndpoint
     */
    public function userAccess()
    {
        return new UserAccessEndpoint($this);
    }

    /**
     * @return \LaVoz\Tinypass\Endpoint\ConversionEndpoint
     */
    public function conversion()
    {
        return new ConversionEndpoint($this);
    }

    /**
     * @return \LaVoz\Tinypass\Endpoint\OfferEndpoint
     */
    public function offer()
    {
        return new OfferEndpoint($this);
    }
}
