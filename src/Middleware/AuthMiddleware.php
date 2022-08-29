<?php

namespace App\Middleware;


use App\Controllers\Utils\DBOperations;
use App\Middleware\Support\FirebaseAuth;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class AuthMiddleware implements MiddlewareInterface
{
    protected $firebaseAuth;

    public function __construct(FirebaseAuth $firebaseAuth)
    {
        $this->firebaseAuth = $firebaseAuth;
    }

    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        $authorization = explode(' ', $request->getHeaderLine('Authorization'));
        $token = $authorization[1] ?? '';

        if (empty($token)) {
            $response = new Response();
            //$response = $handler->handle($request);
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401, 'Unauthorized');
        }

        // Append valid token
        $parsedToken = $this->firebaseAuth->decodeToken($token);
        $request = $request->withAttribute('token', $parsedToken);

        return $handler->handle($request);
    }
}