<?php

// http://www.slimframework.com/docs/tutorial/first-app.html
// https://www.codecourse.com/library/lessons/slim-3-controllers-dependency-injection/controller-basics



// system
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// slim
use \Slim\App;

// middlewares
use \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware;



//
// $app = new App;








// $app = new \Slim\App;
$app = new App([
    'settings' => [
        'debug'               => true,      // On/Off whoops error
        'whoops.editor'       => 'sublime',
        'displayErrorDetails' => true,      // Display call stack in orignal slim error when debug is off
    ]
]);
if ($app->getContainer()->settings['debug'] === false) {
    $container['errorHandler'] = function ($c) {
        return function ($request, $response, $exception) use ($c) {
            $data = [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => explode("\n", $exception->getTraceAsString()),
            ];
            return $c->get('response')->withStatus(500)
                    ->withHeader('Content-Type', 'application/json')
                    ->write(json_encode($data));
        };
    };
}else{
    $app->add(new WhoopsMiddleware);
}

// add middleware
// $app->add(new WhoopsMiddleware);
// middleware
// $app->add(new \Application\Middleware\Cache($db));
// $subject->add( new \Application\Middleware\ExampleMiddleware() );
// $app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware);



// db
// $databasepath = 'sqlite:./application/database/db.sqlite';
// $db  = new PDO($databasepath) or die("cannot open the database");

// http://code.tutsplus.com/tutorials/why-you-should-be-using-phps-pdo-for-database-access--net-12059

$dsn = 'sqlite:../application/database/db.sqlite';
$username = 'root';
$password = 'password_here';
try {
	$db = new PDO($dsn); // also allows an extra parameter of configuration
	// Set errormode to exceptions
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
//	$db->exec("CREATE TABLE Dogs (Id INTEGER PRIMARY KEY, Breed TEXT, Name TEXT, Age INTEGER)");
	//insert some data...
//	$db->exec("INSERT INTO Dogs (Breed, Name, Age) VALUES ('Labrador', 'Tank', 2);".
//	"INSERT INTO Dogs (Breed, Name, Age) VALUES ('Husky', 'Glacier', 7); " .
//	"INSERT INTO Dogs (Breed, Name, Age) VALUES ('Golden-Doodle', 'Ellie', 4);");
	
    # UH-OH! Typed DELECT instead of SELECT!
    // $db->prepare('DELECT name FROM people');
	
	//now output the data to a simple html table...

	$result = $db->query('SELECT * FROM Dogs');

	foreach($result as $row)
	{
		print "<td>".$row['Id']."</td>";
		print "<td>".$row['Breed']."</td>";
		print "<td>".$row['Name']."</td>";
		print "<td>".$row['Age']."</td>";
	}
	// close the database connection
	$db = NULL;
	
	// https://www.if-not-true-then-false.com/2012/php-pdo-sqlite3-example/
	

}
catch(PDOException $e)
{
	die('Could not connect to the database:<br/>' . $e);
}





// routes
// Application middleware
$app->add(function ($request, $response, $next) {
	$response->getBody()->write('BEFORE <pre>');
	$response = $next($request, $response);
	$response->getBody()->write('</pre> AFTER');

	return $response;
});

// Route middleware
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
