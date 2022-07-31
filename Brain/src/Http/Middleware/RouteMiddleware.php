<?php

namespace Brain\Http\Middleware;

use Brain\Router\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Brain\Exception\RouteException;

class RouteMiddleware implements MiddlewareInterface
{
    public function delegate (ServerRequestInterface $request, $next) : ResponseInterface
    {
        $route = $request->getAttribute(Route::class);

        if(! $route || is_null($route)) {

            throw new RouteException("Aucune route disponible pour cette requete", 404);

            exit(404);
        }

        if(empty($route->getMiddleware())) {
            return $next($request);
        }
        
        $middleware = $route->getMiddleware();

        $dispatcher = $next[0];

        $dispatcher->addMiddleware($middleware);

        return $next($request);
    }
}
