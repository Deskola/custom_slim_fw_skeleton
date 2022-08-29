<?php

declare(strict_types=1);


use App\Middleware\CorsMiddleware;
use App\Middleware\JsonBodyParserMiddleware;
use App\Middleware\RateLimitMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(CorsMiddleware::class);
    //$app->add(RateLimitMiddleware::class);
    $app->addBodyParsingMiddleware();
    //$app->add(JsonBodyParserMiddleware::class);
    $app->addRoutingMiddleware();
};
