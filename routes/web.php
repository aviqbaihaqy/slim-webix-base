<?php

$app->get('/', 'app.controller:home')->setName('home');

$app->group('', function () {
    $this->map(['GET', 'POST'], '/login', 'auth.controller:login')->setName('login');
    $this->map(['GET', 'POST'], '/register', 'auth.controller:register')->setName('register');
    $this->map(['GET', 'POST'], '/forgot-password', 'auth.controller:register')->setName('forgot-password');
})->add($container['guest.middleware']);

$app->get('/logout', 'auth.controller:logout')
    ->add($container['auth.middleware']())
    ->setName('logout');

/* $app->group('/api', function(){
    $this->map(['GET', 'POST'],'', 'api.controller:home')->setName('api.home');
});
 */