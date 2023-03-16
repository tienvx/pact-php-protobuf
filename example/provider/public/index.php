<?php

require __DIR__.'/../../../vendor/autoload.php';

use App\Provider\Service\Calculator;
use Plugins\ShapeMessage;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->post('/calculate', function (Request $request, Response $response) {
    $message = new ShapeMessage();
    $message->mergeFromString($request->getBody()->getContents());
    $reply = (new Calculator())->calculate($message);
    $response->getBody()->write($reply->serializeToString());

    return $response->withHeader('Content-Type', 'application/protobuf;message=AreaResponse');
});

$app->run();
