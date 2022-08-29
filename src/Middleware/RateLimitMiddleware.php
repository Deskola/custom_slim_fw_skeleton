<?php

namespace App\Middleware;


use App\Middleware\Support\Limiter;
use Predis\Client;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class RateLimitMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        // Create new predis client instance
        $predis = new Client([
            'scheme' => 'tcp',
            'host' => config('database.redis.default.host'),
            'port' => config('database.redis.default.port'),
            'password' => config('database.redis.default.password')
        ]);


        $limiter = new Limiter($predis);
        $limiter->setRateLimit(4, 10)
            ->setStorageKey(get_ip())
            ->setIdentifier(100);

        $response = $handler->handle($request);

        if ($limiter->hasExceededRateLimit()) {
            $response->getBody()->write(json_encode(["status"=>400,"message"=>"To many request wait for 30 seconds"]));
            return $limiter->getLimitExceededHandler()($response, $request);

        }

        $limiter->incrementRequestCount();

        return $response;


    }

}