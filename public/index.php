<?php

require_once __DIR__ . '/../src/autoload.php';

use Container\Container;
use Psr\Http\Message\ResponseInterface;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Requests\MemberRequests\GetMemberRequestDTO;
use Requests\MemberRequests\InsertMemberRequestDTO;
use Requests\MemberRequests\UpdateMemberRequestDTO;
$app = AppFactory::create();

$container = new Container([
    'host' => '127.0.0.1',
    'port' => '3306',
    'database' => 'library_lending_system',
    'user' => 'carolina',
    'password' => ''
]);

$app->addBodyParsingMiddleware();

$app->get(
    "/",
    function (Request $request, Response $response, $args) {
        $response->getBody()->write('hola');
        return $response;
    }
);



$app->get('/members', function (Request $request, Response $response, $args) use ($container): ResponseInterface {
    $queryParams = $request->getQueryParams();
    $id     = isset($queryParams['id']) ? (int)$queryParams['id'] : null;
    $name   = $queryParams['name']   ?? null;
    $email  = $queryParams['email']  ?? null;
    $state  = isset($queryParams['state'])  ? (int)$queryParams['state']  : null;
    $limit  = isset($queryParams['limit'])  ? (int)$queryParams['limit']  : null;
    $offset = isset($queryParams['offset']) ? (int)$queryParams['offset'] : null;

    $req = GetMemberRequestDTO::fromRequest($id, $name, $email, $state, $limit, $offset);
    $controller = $container->getMemberController();
    $res = $controller->get($req);
    $response->getBody()->write(json_encode($res));
    return $response;
});

$app->post('/register', function (Request $request, Response $response, $args) use ($container): ResponseInterface {
    $params = $request->getParsedBody();
    $name = isset($params['name']) ? $params['name'] : null;
    $email = isset($params['email']) ? $params['email'] : null;
    $state = isset($params['state']) ? (int)$params['state'] : null;

    $req = InsertMemberRequestDTO::fromRequest($name, $email, $state);
    $controller = $container->getMemberController();
    $res = $controller->insert($req);
    $response->getBody()->write(json_encode($res));
    return $response;
});

$app->put('/state', function (Request $request, Response $response, $args) use ($container): ResponseInterface {
    $params = $request->getParsedBody();
    $email = isset($params['email']) ? $params['email'] : null;
    $name = isset($params['name']) ? $params['name'] : null;
    $state = isset($params['state']) ? (int)$params['state'] : null;

    $req = UpdateMemberRequestDTO::fromRequest($email, $name, $state);
    $controller = $container->getMemberController();
    $res = $controller->update($req);
    $response->getBody()->write(json_encode($res));
    return $response;
});

$app->run();
