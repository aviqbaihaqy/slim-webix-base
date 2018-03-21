<?php

namespace App\Middleware\Api;

use App\Middleware\MiddlewareInterface;
use App\Exception\AccessDeniedException;
use App\Exception\UnauthorizedException;
use App\Service\JwtManager;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var string
     */
    protected $role;

    /**
     * @var JwtManager
     */
    protected $jwt;

    /**
     * Constructor.
     *
     * @param JwtManager $jwt
     * @param string     $role
     */
    public function __construct(JwtManager $jwt, $role = null)
    {
        $this->jwt = $jwt;
        $this->role = $role;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        if (!$this->jwt->getAccessToken()) {
            throw new UnauthorizedException();
        }

        if ($this->role) {
            if (!$this->jwt->getAccessToken()->user->inRole($this->role)) {
                throw new AccessDeniedException('Access denied: User must have role ' . $this->role);
            }
        }

        return $next($request, $response);
    }
}
