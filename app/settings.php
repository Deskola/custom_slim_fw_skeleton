<?php

declare(strict_types=1);

use DI\Container;
use Monolog\Logger;

return function (Container $container) {
    $container->set('settings', function () {

        return [

            'displayErrorDetails' => true, // Should be set to false in production
            'logError' => false,
            'logErrorDetails' => false,
            'logger' => [
                'name' => 'slim-app',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'views' => [
                'path' => __DIR__ . '/../src/views',
                'settings' => ['cache' => false],
            ],
            'database' => [
                'driver' => 'mysql',
                'host' => 'localhost',
                'dbName' => 'new_slime_test',
                'dbUser' => 'root',
                'dbPass' => ''
            ],

        ];
    });
};

