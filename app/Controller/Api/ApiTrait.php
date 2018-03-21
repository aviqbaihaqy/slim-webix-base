<?php
namespace App\Controller\Api;

use App\Exception\AccessDeniedException;
use App\Exception\UnauthorizedException;
use App\Model\User;
use App\Service\JwtManager;
use App\Service\Constants;
use Awurth\SlimValidation\Validator;
use Cartalyst\Sentinel\Sentinel;
use Psr\Container\ContainerInterface;
use Slim\Exception\NotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;

trait ApiTrait
{

    /**
     * Gets the current authenticated user.
     *
     * @return User|null
     */
    protected function getUser()
    {
        $token = $this->jwt->getAccessToken();

        return $token ? $token->user : null;
    }

    /**
     * Throws an AccessDeniedException if user doesn't have the required role.
     *
     * @param string $role
     *
     * @throws AccessDeniedException
     */
    protected function requireRole($role)
    {
        $user = $this->getUser();

        if (null === $user || !$user->inRole($role)) {
            throw $this->accessDeniedException('Access denied: User must have role ' . $role);
        }
    }

    /**
     * Gets request parameters.
     *
     * @param Request  $request
     * @param string[] $params
     * @param mixed    $default
     *
     * @return array
     */
    protected function params(Request $request, array $params, $default = null)
    {
        $data = [];
        foreach ($params as $param) {
            $data[$param] = $request->getParam($param, $default);
        }

        return $data;
    }

    /**
     * Returns validation errors as a JSON array.
     *
     * @param Response $response
     *
     * @return Response
     */
    protected function validationErrors(Response $response)
    {
        return $this->json($response, $this->validator->getErrors(), 400);
    }

}
