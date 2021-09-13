<?php

namespace Infrastructure\Http\Client;

/**
 * Interface HttpClientInterface
 * @package Infrastructure\Http\Client
 */
interface HttpClientInterface
{
    /**
     * GET-request
     *
     * @param string $uri
     * @param array $options
     * @return HttpClientInterface
     */
    public function get(string $uri, array $options = []): HttpClientInterface;

    /**
     * @param string $uri
     * @param array $options
     * @return HttpClientInterface
     */
    public function post(string $uri, array $options = []): HttpClientInterface;

    /**
     * @return string
     */
    public function getContents(): string;

    /**
     * @return int
     */
    public function getStatusCode(): int;
}
