<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use HttpPHP\Transport\Enums\Method;
use HttpPHP\Transport\Request;

$response = Request::build(
    uri: 'https://jsonplaceholder.typicode.com/posts?page=2',
    method: Method::GET,
)->send();

var_dump($response->headers());
