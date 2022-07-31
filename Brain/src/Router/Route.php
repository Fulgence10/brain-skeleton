<?php

namespace Brain\Router;

use Brain\Injector\Facade\Injector;
use Opis\Closure\ReflectionClosure;
use ReflectionMethod;

class Route
{
    private $path;

    private $name;
    
    private $handler;

    private $with = [];
    
    private $params = [];

    private $middleware = [];

    /**
     * constructor
     *
     * @param string $path
     * @param callable|string $handler
     * @param string $name
     */
    public function __construct(string $path, $handler, string $name = "default")
    {
        $this->path = trim($path, '/');

        $this->name = $name;

        $this->handler = $handler;
    }

    /**
     *
     * @param string $url
     * @return boolean
     */
    public function match(string $url) : bool
    {
        // path of user
        $url = trim($url, '/');
        
        // path of developper
        $path = preg_replace_callback(
            "#:([\w]+)#", 
            [$this, "patternReplacer"], 
            $this->path
        );
        // path match
        $path = "#^$path$#";

        if(preg_match($path, $url, $matches)) {
            array_shift($matches);
            $this->params = (array) $matches;
            return true;
        }
        return false;
    }

    /**
     *
     * @param array $pattern
     * @return string
     */
    private function patternReplacer($key) : string
    {
        if (isset($this->with[$key[1]])) {
			return '(' . $this->with[$key[1]] . ')';
		}
		return '([^/]+)';
    }

    /**
     *
     * @param string $key
     * @param string $val
     * @return self
     */
    public function with(string $key, string $val) : self
    {
        $this->with[$key] = str_replace('(', '(?:', $val);

        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function call()
    {
        $handler = $this->getHandler();

        if(is_array($handler)) {
            $reflexion = new ReflectionMethod(...$handler);
        } else {
            $reflexion = new ReflectionClosure($handler);
        }

        $reflexionParam = $reflexion->getParameters();
        
        $parameters = [];

        foreach ($reflexionParam as $param) {
            if(Injector::has($param->getType()->getName())) {
                $parameters[] = Injector::get(
                    $param->getType()->getName()
                );
            } else if($param->getClass() && $param->getClass()->isInstantiable()){
                $parameters[] = $param->getClass()->newInstance();
            } else if($param->isDefaultValueAvailable()) {
                $parameters[] = $param->getDefaultValue();
            } 
        }
        
        $parameters = array_merge(
            $parameters, 
            $this->getParams()
        );
        
        return call_user_func_array($handler, $parameters);
    }

    /**
     *
     * @param array $middleware
     * @return self
     */
    public function middleware(array $middleware) : self
    {
        $this->middleware = $middleware;

        return $this;
    }

    /**
     * Get the value of params
     *
     * @return array
     */
    public function getParams() : array
    {
        return $this->params;
    }

    /**
     * Get the value of handler
     * 
     * @return mixed
     */ 
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * Get the value of middleware
     * @return array
     */ 
    public function getMiddleware() : array
    {
        return $this->middleware;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     *
     * @param array $params
     * @return string
     */ 
    public function getPath(array $params = []) : string
    {
        $path = $this->path;
        foreach ($params as $k => $v) {
            $path = str_replace(":$k", $v, $path);
        }
        return '/'.$path;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }
}
