<?php

declare(strict_types=1);

namespace HttpPHP\Transport\Concerns;

use HttpPHP\Headers\Contracts\HeaderContract;
use HttpPHP\Messages\Contracts\MessageContract;
use HttpPHP\Transport\Contracts\HttpClientContract;
use HttpPHP\Transport\Enums\Method;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @mixin HttpClientContract
 */
trait SendsHttpRequests
{
    /**
     * Send a GET Request.
     *
     * @param string $uri
     * @param array<int,HeaderContract> $headers
     * @return ResponseInterface
     */
    public function get(string $uri, array $headers = []): ResponseInterface
    {
        return $this->send(
            method: Method::GET,
            uri: $uri,
            headers: $headers,
        );
    }

    /**
     * Send a POST Request.
     *
     * @param string $uri
     * @param MessageContract $payload
     * @param array<int,HeaderContract> $headers
     * @return ResponseInterface
     */
    public function post(string $uri, MessageContract $payload, array $headers = []): ResponseInterface
    {
        return $this->send(
            method: Method::POST,
            uri: $uri,
            payload: $payload,
            headers: $headers,
        );
    }

    /**
     * Send a PUT Request.
     *
     * @param string $uri
     * @param MessageContract $payload
     * @param array<int,HeaderContract> $headers
     * @return ResponseInterface
     */
    public function put(string $uri, MessageContract $payload, array $headers = []): ResponseInterface
    {
        return $this->send(
            method: Method::PUT,
            uri: $uri,
            payload: $payload,
            headers: $headers,
        );
    }

    /**
     * Send a PATCH Request.
     *
     * @param string $uri
     * @param MessageContract $payload
     * @param array<int,HeaderContract> $headers
     * @return ResponseInterface
     */
    public function patch(string $uri, MessageContract $payload, array $headers = []): ResponseInterface
    {
        return $this->send(
            method: Method::PATCH,
            uri: $uri,
            payload: $payload,
            headers: $headers,
        );
    }

    /**
     * Send a DELETE Request.
     *
     * @param string $uri
     * @param array<int,HeaderContract> $headers
     * @return ResponseInterface
     */
    public function delete(string $uri, array $headers = []): ResponseInterface
    {
        return $this->send(
            method: Method::DELETE,
            uri: $uri,
            headers: $headers,
        );
    }

    /**
     * Send an OPTIONS Request.
     *
     * @param string $uri
     * @param array<int,HeaderContract> $headers
     * @return ResponseInterface
     */
    public function options(string $uri, array $headers = []): ResponseInterface
    {
        return $this->send(
            method: Method::OPTIONS,
            uri: $uri,
            headers: $headers,
        );
    }

    /**
     * Send a HEAD Request.
     *
     * @param string $uri
     * @param array<int,HeaderContract> $headers
     * @return ResponseInterface
     */
    public function head(string $uri, array $headers = []): ResponseInterface
    {
        return $this->send(
            method: Method::HEAD,
            uri: $uri,
            headers: $headers,
        );
    }

    /**
     * Send a HTTP Request.
     *
     * @param Method $method
     * @param string $uri
     * @param MessageContract|null $payload
     * @param array<int,HeaderContract> $headers
     * @return ResponseInterface
     */
    public function send(Method $method, string $uri, null|MessageContract $payload = null, array $headers = []): ResponseInterface
    {
        $request = $this->request->createRequest(
            method: $method->value,
            uri: $uri,
        );

        /**
         * @var HeaderContract $header
         */
        foreach (array_merge($this->headers, $headers) as $header) {
            $request = $request->withAddedHeader(
                name: $header->key(),
                value: $header->value(),
            );
        }

        if (null !== $payload) {
            $request = $request->withBody(
                body: $this->stream->createStream(
                    content: $payload->payload()->body(),
                ),
            );
        }

        try {
            $response = $this->client->sendRequest(
                request: $request,
            );
        } catch (Throwable $exception) {
            throw $exception;
        }

        return $response;
    }
}