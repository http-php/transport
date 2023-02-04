<?php

declare(strict_types=1);

namespace HttpPHP\Transport;

use HttpPHP\Messages\Contracts\MessageContract;
use HttpPHP\Transport\Contracts\HttpClientContract;
use HttpPHP\Transport\Enums\Method;
use Psr\Http\Message\ResponseInterface;

final class Request
{
    public function __construct(
        private readonly string $uri,
        private readonly HttpClientContract $client,
        private null|MessageContract $message = null,
        private Method $method = Method::GET,
    ) {}

    public static function build(
        string $uri,
        null|HttpClientContract $client = null,
        null|MessageContract $message = null,
        Method $method = Method::GET,
    ): Request {
        return new Request(
            uri: $uri,
            client: $client ?? HttpClient::make(),
            message: $message,
            method: $method,
        );
    }

    public function send(): ResponseInterface
    {
        return $this->client->send(
            method: $this->method,
            uri: $this->uri,
            payload: $this->message,
            headers: $this->message->headers(),
        );
    }

    public function withMessage(MessageContract $message): Request
    {
        $this->message = $message;

        return $this;
    }

    public function setMethod(Method $method): Request
    {
        $this->method = $method;

        return $this;
    }
}