<?php

declare(strict_types=1);

namespace HttpPHP\Transport\Contracts;

use HttpPHP\Headers\Contracts\HeaderContract;
use HttpPHP\Messages\Contracts\MessageContract;
use HttpPHP\Transport\Enums\Method;
use Psr\Http\Message\ResponseInterface;

interface HttpClientContract
{
    /**
     * Send a GET Request.
     *
     * @param string $uri
     * @param array<int|string,HeaderContract> $headers
     * @return ResponseInterface
     */
    public function get(string $uri, array $headers = []): ResponseInterface;

    /**
     * Send a POST Request.
     *
     * @param string $uri
     * @param MessageContract $payload
     * @param array<int|string,HeaderContract> $headers
     * @return ResponseInterface
     */
    public function post(string $uri, MessageContract $payload, array $headers = []): ResponseInterface;

    /**
     * Send a PUT Request.
     *
     * @param string $uri
     * @param MessageContract $payload
     * @param array<int|string,HeaderContract> $headers
     * @return ResponseInterface
     */
    public function put(string $uri, MessageContract $payload, array $headers = []): ResponseInterface;

    /**
     * Send a PATCH Request.
     *
     * @param string $uri
     * @param MessageContract $payload
     * @param array<int|string,HeaderContract> $headers
     * @return ResponseInterface
     */
    public function patch(string $uri, MessageContract $payload, array $headers = []): ResponseInterface;

    /**
     * Send a DELETE Request.
     *
     * @param string $uri
     * @param array<int|string,HeaderContract> $headers
     * @return ResponseInterface
     */
    public function delete(string $uri, array $headers = []): ResponseInterface;

    /**
     * Send an OPTIONS Request.
     *
     * @param string $uri
     * @param array<int|string,HeaderContract> $headers
     * @return ResponseInterface
     */
    public function options(string $uri, array $headers = []): ResponseInterface;

    /**
     * Send a HEAD Request.
     *
     * @param string $uri
     * @param array<int|string,HeaderContract> $headers
     * @return ResponseInterface
     */
    public function head(string $uri, array $headers = []): ResponseInterface;

    /**
     * Send a HTTP Request.
     *
     * @param Method $method
     * @param string $uri
     * @param MessageContract|null $payload
     * @param array<int|string,HeaderContract> $headers
     * @return ResponseInterface
     */
    public function send(Method $method, string $uri, null|MessageContract $payload = null, array $headers = []): ResponseInterface;
}
