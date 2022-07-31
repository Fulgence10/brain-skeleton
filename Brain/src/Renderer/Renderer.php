<?php

namespace Brain\Renderer;

use Brain\Injector\Facade\Injector;
use Brain\Renderer\Exception\RendererException;

class Renderer 
{
    /**
     *
     * @var array
     */
    private $template = [];

    /**
     *
     * @var string
     */
    private $target;
    

    /**
     * Undocumented function
     */
    public function __construct()
    {
        $this->template = [
            "twig" => Injector::get(\Brain\Renderer\TwigRenderer::class),
            "default" => Injector::get(\Brain\Renderer\PHPRenderer::class)
        ]; 

        $target = Injector::get("template");
        if(! $target) {
            throw new RendererException("Aucun moteur defini dans la configuration");
        }
        $this->target = $target;
    }

    /**
     *
     * @param string $namespace
     * @param string|null $path
     * @return void
     */
    public function addPath (string $namespace, ?string $path = null) : void
    {
        $this->template[$this->target]->addPath($namespace, $path);
    }

    /**
     *
     * @param string $view
     * @param array $parameters
     * @return string
     */
    public function render (string $view, array $parameters = []) : string
    {
        return $this->template[$this->target]->render(
            $view . Injector::get('extension'), 
            $parameters
        );
    }

    /**
     *
     * @param string $name
     * @param mixed $value
     * @return self
     */
    public function addGlobal (string $name, $value) : self
    {
        $this->template[$this->target]->addGlobal($name, $value);
        
        return $this;
    }
}
