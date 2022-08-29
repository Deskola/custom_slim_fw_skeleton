<?php

use DI\Container;
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

return function (Container $container) {
    $options = data_get(
        config('database.connections'),
        config('database.default')
    );

    $capsule = new Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($options);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};
