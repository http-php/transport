<?php

declare(strict_types=1);

namespace HttpPHP\Transport;

use HttpPHP\Headers\Contracts\HeaderContract;
use HttpPHP\Headers\Header;
use JustSteveKing\StatusCode\Http;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

final readonly class Response
{
    /**
     * @param ResponseInterface $response
     */
    public function __construct(
        private ResponseInterface $response,
    ) {
    }

    /**
     * @param ResponseInterface $response
     * @return Response
     */
    public static function build(ResponseInterface $response): Response
    {
        return new Response(
            response: $response,
        );
    }

    /**
     * @return Http
     */
    public function status(): Http
    {
        return Http::from(
            value: $this->response->getStatusCode(),
        );
    }

    /**
     * @return StreamInterface
     */
    public function body(): StreamInterface
    {
        return $this->response->getBody();
    }

    /**
     * @return array<mixed,mixed>
     * @throws \JsonException
     */
    public function json(): array
    {
        return (array) json_decode(
            json: $this->body()->getContents(),
            associative: true,
            depth: 512,
            flags: JSON_THROW_ON_ERROR,
        );
    }

    /**
     * @return array<int,HeaderContract>
     */
    public function headers(): array
    {
        $headers = [];

        foreach ($this->response->getHeaders() as $key => $value) {
            $headers[] = Header::make(
                key: $key,
                value: $value[0],
            );
        }

        return $headers;
    }
}
