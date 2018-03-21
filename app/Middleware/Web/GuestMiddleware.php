<?php

namespace App\Middleware\Web;

use Slim\Http\Request;
use Slim\Http\Response;
use Cartalyst\Sentinel\Sentinel;
use Slim\Interfaces\RouterInterface;
use App\Middleware\MiddlewareInterface;

class GuestMiddleware implements MiddlewareInterface
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var Sentinel
     */
    protected $sentinel;

    /**
     * Constructor.
     *
     * @param RouterInterface $router
     * @param Sentinel        $sentinel
     */
    public function __construct(RouterInterface $router, Sentinel $sentinel)
    {
        $this->router = $router;
        $this->sentinel = $sentinel;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        if ($this->sentinel->check()) {
            return $response->withRedirect($this->router->pathFor('home'));
        }

        return $next($request, $response);
    }
}
