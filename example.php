<?php

declare(strict_types=1);

use HttpPHP\Transport\Enums\Method;
use HttpPHP\Transport\Request;

$request = Request::build(
    uri: 'https://api.test.com/resource',
    method: Method::POST,
);
