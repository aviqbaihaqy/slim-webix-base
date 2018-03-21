<?php
namespace App\Middleware\Web;

use Slim\Views\Twig;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Middleware\MiddlewareInterface;
use Interop\Container\ContainerInterface;

class BreadCrumbsMiddleware implements MiddlewareInterface
{
    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(Request $request, Response $response, callable $next)
    {

        unset($_SESSION['breadCrumbs']);
        //ALWAYS BE HOME
        $_SESSION['breadCrumbs'][] = array("route" => "Dashboard", "uri" => "dashboard");

        //GET THE NAME OF CURRENT SELECTED PAGE

        // die(dump($request->getAttribute('route')));
        // die(dump($request->getAttribute('route')));

        $routeName = '';

        if(!is_null($request->getAttribute('route'))){
            $routeName = $request->getAttribute('route')->getName();
        }

        // die(dump($routeName));

        //BUILD BREADCRUMBS
        switch ($routeName) {
            case "contact":
                $_SESSION['breadCrumbs'][] = array("route" => ucfirst($routeName), "uri" => $routeName);
                break;
            case "auth.signup":
                $_SESSION['breadCrumbs'][] = array("route" => "Register", "uri" => $routeName);
                break;
        }

        //ALLOW VIEW TO USE IT
        $this->twig->getEnvironment()->addGlobal('breadCrumbs', $_SESSION['breadCrumbs']);
        $response = $next($request, $response);
        return $response;

    }



}
