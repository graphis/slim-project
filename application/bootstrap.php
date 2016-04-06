<?php

// http://www.slimframework.com/docs/tutorial/first-app.html
// https://www.codecourse.com/library/lessons/slim-3-controllers-dependency-injection/controller-basics



use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;



$app = new \Slim\App;


// routes
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});



$app->run();