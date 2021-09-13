<?php

namespace Infrastructure\Http\Client\Symfony;

use Infrastructure\Http\Client\HttpClientInterface;
use Symfony\Component\BrowserKit\CookieJar;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

/**
 * Class BrowserKit
 * @package Infrastructure\Http\Client\Guzzle
 */
class BrowserKit implements HttpClientInterface
{
    /**
     * @var HttpBrowser
     */
    protected $client;

    /**
     * @var \Symfony\Component\BrowserKit\Response
     */
    protected $response;

    /** @var String */
    protected $uri;

    /**
     * BrowserKit constructor.
     */
    public function __construct()
    {
        $this->client = new HttpBrowser(HttpClient::create(), null, new CookieJar());
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
        return $this->setResponse($this->client->request('GET', $uri, $options));
    }

    /**
     * @param string $uri
     * @param array $options
     * @return HttpClientInterface
     */
    public function post(string $uri, array $options = []): HttpClientInterface
    {
        return $this->setResponse($this->client->request('POST', $uri, $options));
    }

    /**
     * @return string
     */
    public function getContents(): string
    {
        return $this->response->getContent();
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    /**
     * @inheritDoc
     */
    public function isSuccess(): bool
    {
        return $this->response->getStatusCode() >= 200 && $this->response->getStatusCode() < 300;
    }

    /**
     * @param $response
     * @return $this
     */
    protected function setResponse(Crawler $response): self
    {
        $this->response = $this->client->getResponse();
        return $this;
    }

    public function getUri(): string
    {
        if (null === $this->uri) {
            $this->uri = $this->client->getCrawler()->getUri();
        }
        return $this->uri;
    }

    public function refresh(): void
    {
        $this->client->restart();
        unset($this->client);
        $this->client = new HttpBrowser(HttpClient::create());
    }
}
