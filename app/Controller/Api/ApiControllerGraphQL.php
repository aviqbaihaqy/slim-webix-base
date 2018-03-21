<?php

namespace App\Controller\Api;

use GraphQL\GraphQL;
use Slim\Http\Request;
use Slim\Http\Response;
use GraphQL\Type\Schema;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use Awurth\Slim\Helper\Controller\Controller;

class ApiControllerGraphQL extends Controller
{
    public function home(Request $request, Response $response)
    {
        try {
            $queryType = new ObjectType([
                'name' => 'Query',
                'fields' => [
                    'echo' => [
                        'type' => Type::string(),
                        'args' => [
                            'message' => ['type' => Type::string()],
                        ],
                        'resolve' => function ($root, $args) {
                            return $root['prefix'] . $args['message'];
                        },
                    ],
                ],
            ]);
            $mutationType = new ObjectType([
                'name' => 'Calc',
                'fields' => [
                    'sum' => [
                        'type' => Type::int(),
                        'args' => [
                            'x' => ['type' => Type::int()],
                            'y' => ['type' => Type::int()],
                        ],
                        'resolve' => function ($root, $args) {
                            return $args['x'] + $args['y'];
                        },
                    ],
                ],
            ]);
            // See docs on schema options:
            // http://webonyx.github.io/graphql-php/type-system/schema/#configuration-options
            $schema = new Schema([
                'query' => $queryType,
                'mutation' => $mutationType,
            ]);

            $rawInput = file_get_contents('php://input');
            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variableValues = isset($input['variables']) ? $input['variables'] : null;
            $rootValue = ['prefix' => 'You said: '];
            $result = GraphQL::executeQuery($schema, $query, $rootValue, null, $variableValues);
            $output = $result->toArray();
        } catch (\Exception $e) {
            $output = [
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ];
        }
        // dd($output);
        
        // header('Content-Type: application/json; charset=UTF-8');
        // echo json_encode($output);

        return $response->withJson($output, 200);

    }
}
