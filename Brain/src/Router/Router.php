<?php

namespace Brain\Router;

class Router
{
    /**
     * all routes
     *
     * @var array
     */
    private array $routes = [];


    /**
     *
     * @var array
     */
    private array $routesCollections = [];


    /**
     * add route in property routes
     *
     * @param string $method
     * @param string $path
     * @param string|callable $handler
     * @return Route
     */
    public function add(string $method, string $path, $handler): Route
    {
        $route = new Route($path, $handler); 

        $this->routesCollections[] = $route;
        
        $this->routes[$method][] = $route;
        
        return $route;
    }

    /**
     *
     * @param string $name
     * @return string
     */
    public function url(string $name, array $params = [])  
    {
        foreach ($this->routesCollections as $route) {
            if($name == $route->getName()) {
                return $route->getPath($params);
            }
        }
    }

    /**
     * match route by url
     *
     * @param string $url
     * @return void
     */
    public function match(string $url) 
    {
        if (! isset($this->routes[$_SERVER["REQUEST_METHOD"]])) {
            return false;
        }

        foreach ($this->routes[$_SERVER["REQUEST_METHOD"]] as $route) {
            if($route->match($url)) {
                return $route;
            }
        }
    }
}