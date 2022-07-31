<?php

namespace Brain\Application;

use Brain\Http\Request;
use Brain\Router\Route;
use Brain\Router\Router;
use Brain\Injector\Facade\Injector;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Brain
{

    /**
     * instance of router
     *
     * @var Router
     */
    private $router;

    /**
     *
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * constructor
     *
     * @param string $config
     */
    public function __construct(string $config) 
    {
        Injector::init($config);

        $this->router = new Router();

        // dd($this->getAllMiddlewares());
        $this->dispatcher = new Dispatcher($this->getAllMiddlewares());
    }

    /**
     * 
     *
     * @return array
     */
    public function getAllMiddlewares () : array
    {
        return array_merge(
            Injector::get('app.middleware'), 
            Injector::get('brain.middleware')
        );
    }

    /**
     *
     * @param string $path
     * @param $handler
     * @return Route
     */
    public function get (string $path, $handler) : Route
    {
        return $this->router->add('GET', $path, $this->resolveInsatnce($handler));
    }

    /**
     *
     * @param string $path
     * @param $handler
     * @return Route
     */
    public function post (string $path, $handler) : Route
    {
        return $this->router->add('POST', $path, $this->resolveInsatnce($handler));
    }

    /**
     *
     * @param string $methode
     * @param string $path
     * @param $handler
     * @return Route
     */
    public function maps (string $methode, string $path, $handler) : Route
    {
        return $this->router->add(
            $methode, 
            $path, 
            $this->resolveInsatnce($handler)
        );
    }

    /**
     *
     * @param string $path
     * @param $handler
     * @return void
     */
    public function any (string $path, $handler) : void
    {
        foreach (['GET', 'POST'] as $method) {
            $this->router->add(
                $method,$path, 
                $this->resolveInsatnce($handler)
            );
        }
    }


    /**
     * Undocumented function
     *
     * @param mixed $handler
     * @return mixed
     */
    public function resolveInsatnce ($handler)
    {
        if(is_array($handler)) {
            if(Injector::has($handler[0])) {
                $output[0] = Injector::get($handler[0]);
            } else {
                $output[0] = new $handler[0]();
            }
            $output[1] = $handler[1];
        } else {
            $output = $handler;
        }
        return $output;
    }

    /**
     * application started 
     * @param Request $request
     * @return void
     */
    public function start (ServerRequestInterface $request) : void
    {
        $url = $request->getQueryParams()['url'] ?? $request->getUri()->getPath();

        $route = $this->router->match($url);

        Injector::set(Router::class, $this->router);

        Injector::set(ServerRequestInterface::class, $request);
        
        $request = $request->withAttribute(Route::class, $route);
        
        $response = $this->dispatcher->delegate($request);
        
        $this->send($response);
    }

    /**
     * send response and render
     * @param ResponseInterface $response
     * @return void
     */
    public function send (ResponseInterface $response) : void
    {
        $http_line = sprintf(
            'HTTP/%s %s %s',
            $response->getProtocolVersion(),
            $response->getStatusCode(),
            $response->getReasonPhrase()
        );

        header($http_line, true, $response->getStatusCode());

        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header("$name: $value", false);
            }
        }

        $stream = $response->getBody();

        if ($stream->isSeekable()) {
            $stream->rewind();
        }

        while (! $stream->eof()) {
            echo $stream->read(1024 * 8);
        }
    } 
    
}
