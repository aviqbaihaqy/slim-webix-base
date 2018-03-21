<?php

$app->group('/dashboard', function () {
    $this->get('', 'dashboard.controller:index')->setName('dashboard');
    $this->get('/my-account', 'dashboard.controller:index')->setName('my-account');
    
    $this->group('/surat', function () {
        $this->get('/masuk', 'dashboard.controller:index')->setName('surat-masuk');
    });

})->add($container['auth.middleware']());
