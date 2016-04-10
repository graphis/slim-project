<?php

// http://www.slimframework.com/docs/tutorial/first-app.html
// https://www.codecourse.com/library/lessons/slim-3-controllers-dependency-injection/controller-basics



// system
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// slim
// use \Slim\App;



// config file
$config = [
    'settings' => [
        'displayErrorDetails' => true,
        'whatever' => '42 fortytwo',

        'logger' => [
            'name' => 'slim-app',
            'level' => Monolog\Logger::DEBUG,
            'path' => __DIR__ . '/../logs/app.log',
        ],
    ]
];


//
$app = new \Slim\App($config);


    $container = $app->getContainer();
    $container['logger'] = function ($c) {
        $eek = $c->get('settings')['whatever'];
        //$logger = new Monolog\Logger($settings['name']);
        //$logger->pushProcessor(new Monolog\Processor\UidProcessor());
        //$logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
//        return $eek;
        return $response->getBody()->write("Eat this" . $eek);
    };



// routes
// Application middleware
// get executed every time
$app->add(function ($request, $response, $next) {
	$response->getBody()->write('BEFORE <pre>');
	$response = $next($request, $response);
	$response->getBody()->write('</pre> AFTER');

	return $response;
});

// Route middleware
// route should call this with "->add($mw);"
$mw = function ($request, $response, $next) {
    $response->getBody()->write('BEFORE');
    $response = $next($request, $response);
    $response->getBody()->write('AFTER');

    return $response;
};

$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
})->add($mw);


// test Domain controller
$app->any('/mikka/{name}', 'Application\Domain\Mikkamakka');




$app->run();



// eof
