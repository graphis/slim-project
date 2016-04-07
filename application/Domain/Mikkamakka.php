<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

namespace Application\Domain;

class Mikkamakka {


	// see http://juliangut.com/blog/slim-controller

	//(Request $request, Response $response, $app)
    public function __invoke()
    {
        echo 'asasas';
		
	    //$name = $request->getAttribute('name');
	   // $response->getBody()->write("Hello, $name");

	    //return $response;
    }


}