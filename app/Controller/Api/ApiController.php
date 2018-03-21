<?php

namespace App\Controller\Api;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Api\ApiTrait;
use Awurth\Slim\Helper\Controller\RestController;

class ApiController extends RestController
{
    use ApiTrait;
    
    public function root(Request $request, Response $response)
    {
        return $this->ok($response, [
            'security' => [
                'login' => $this->path('api.login'),
                'register' => $this->path('api.register'),
                'refresh_token' => $this->path('api.jwt.refresh'),
                'user' => $this->path('api.users.me')
            ]
        ]);
    }
}
