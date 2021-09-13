<?php

namespace Infrastructure\Http\Client\Guzzle;

use GuzzleHttp\Client as GuzzleClient;
use Infrastructure\Http\Client\HttpClientInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class HttpClient
 * @package Infrastructure\Http\Client\Guzzle
 */
class HttpClient implements HttpClientInterface
{
    /**
     * @var GuzzleClient
     */
    protected $client;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * GuzzleClient constructor.
     */
    public function __construct()
    {
        $this->client = new GuzzleClient();
    }

    /**
     * GET-request
     *
     * @param string $uri
     * @param array $options
     * @return HttpClientInterface
     */
    public function get(string $uri, array $options = []): HttpClientInterface
    {
        return $this->setResponse($this->client->get($uri, $options));
    }

    /**
     * @param string $uri
     * @param array $options
     * @return HttpClientInterface
     */
    public function post(string $uri, array $options = []): HttpClientInterface
    {
        return $this->setResponse($this->client->post($uri, $options));
    }

    /**
     * @return string
     */
    public function getContents(): string
    {
        return $this->response->getBody()->getContents();
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    /**
     * @param $response
     * @return $this
     */
    protected function setResponse(ResponseInterface $response): self
    {
        $this->response = $response;

        return $this;
    }
}
