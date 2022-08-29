<?php

declare(strict_types=1);

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {
    $settings = $app->getContainer()->get('settings');
    $log = $settings['logger'];
    $logger = new Logger($log['name']);
    $streamHandler = new StreamHandler($log['path'], 100);
    $logger->pushHandler($streamHandler);

    if (env('APP_DEBUG', false)){
        $errorMiddleware = $app->addErrorMiddleware(
            $settings['displayErrorDetails'],
            $settings['logError'],
            $settings['logErrorDetails'],
            $logger
        );
        $errorMiddleware->setDefaultErrorHandler(function (
            ServerRequestInterface $request,
            Throwable $exception
        ) use ($app, $logger) {
            $logger->error($exception->getMessage());
            $payload = ['status' => '400', 'error' => "403 error. Kindly Contact the web admin"];

            $response = $app->getResponseFactory()->createResponse();
            $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
            $response->withHeader("Content-Type", "application/json")
                ->withHeader("Accept", "application/json")
                ->withStatus(400);

            return $response;
        });
    }
};
