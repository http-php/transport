<?php

declare(strict_types=1);

namespace HttpPHP\Transport;

use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use HttpPHP\Headers\Contracts\HeaderContract;
use HttpPHP\Transport\Concerns\SendsHttpRequests;
use HttpPHP\Transport\Contracts\HttpClientContract;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final class HttpClient implements HttpClientContract
{
    use SendsHttpRequests;

    /**
     * @param ClientInterface $client
     * @param RequestFactoryInterface $request
     * @param StreamFactoryInterface $stream
     * @param array<int,HeaderContract> $headers
     */
    public function __construct(
        private readonly ClientInterface $client,
        private readonly RequestFactoryInterface $request,
        private readonly StreamFactoryInterface $stream,
        private readonly array $headers = [],
    ) {
    }

    /**
     * @param ClientInterface|null $client
     * @param RequestFactoryInterface|null $request
     * @param StreamFactoryInterface|null $stream
     * @param array<int,HeaderContract> $headers
     * @return HttpClientContract
     */
    public static function make(
        null|ClientInterface $client = null,
        null|RequestFactoryInterface $request = null,
        null|StreamFactoryInterface $stream = null,
        array $headers = [],
    ): HttpClientContract {
        return new HttpClient(
            client: $client ?? HttpClientDiscovery::find(),
            request: $request ?? Psr17FactoryDiscovery::findRequestFactory(),
            stream: $stream ?? Psr17FactoryDiscovery::findStreamFactory(),
            headers: $headers,
        );
    }
}
