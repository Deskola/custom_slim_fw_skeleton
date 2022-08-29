<?php

use App\Controllers\WelcomeController;
use Slim\App;
use Slim\Exception\HttpNotFoundException;


return function (App $app) {
    $app->options('/{routes:.+}', function ($request, $response) {
        return $response;
    });

    $app->group("/api/v1", function ($app) {
        /*
        |--------------------------------------------------------------------------
        | Authentication Routes
        |--------------------------------------------------------------------------
        |
        |
        |
        |
        |
        */


        $app->get("/debug", [WelcomeController::class, 'file_display']);
    });

    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });
};
