<?php

// http://www.slimframework.com/docs/tutorial/first-app.html
// https://www.codecourse.com/library/lessons/slim-3-controllers-dependency-injection/controller-basics



// system
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// framework
use \Slim\App;

// application
use Application\Middleware\Debug;



// 
$app = new App;

// add middleware
$app->add(new Debug());




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
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});


// test Domain controller
$app->any('/mikka/{name}', 'Application\Domain\Mikkamakka');




$app->run();



// eof
