<?php

namespace Application\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Debug
{
    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $response->getBody()->write('<pre>');

        // http://www.slimframework.com/docs/cookbook/retrieving-current-route.html
        $route = $request->getAttribute('route');
//        $name = $route->getName();
//        $groups = $route->getGroups();
//        $methods = $route->getMethods();
//        $arguments = $route->getArguments();

//        $response->getBody()->write('arguments: ' . $arguments['name'] . '<br/>');

        $response = $next($request, $response);
        $response->getBody()->write('</pre>');

        return $response;
    }
}