<?php

use App\Middleware\Web\AuthMiddleware;
use App\Middleware\Web\GuestMiddleware;
use App\Middleware\Api\AuthMiddleware as AuthApiMiddeleware;
use App\Middleware\Api\CorsMiddleware;
use App\Middleware\Api\JwtMiddleware;

$container['guest.middleware'] = function ($container) {
    return new GuestMiddleware($container['router'], $container['auth']);
};

$container['auth.middleware'] = function ($container) {
    return function ($role = null) use ($container) {
        return new AuthMiddleware($container['router'], $container['flash'], $container['auth'], $role);
    };
};

$container['auth.api.middleware'] = function ($container) {
    return function ($role = null) use ($container) {
        return new AuthApiMiddeleware($container['jwt'], $role);
    };
};


$app->add($container['csrf']);

$app->add(new JwtMiddleware($container['jwt']));
$app->add(new CorsMiddleware($container['settings']['cors']));

