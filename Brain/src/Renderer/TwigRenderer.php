<?php

namespace Brain\Renderer;

use Brain\Injector\Facade\Injector;
use Twig_Environment;
use Twig_Loader_Filesystem;
use Brain\Renderer\TwigExtensions;

class TwigRenderer implements RendererInterface
{
    /**
     *
     * @var Twig_Loader_Filesystem
     */
    private $loader;

    /**
     *
     * @var Twig_Environment
     */
    private $twig;
    /**
     * Undocumented function
     */
    public function __construct(string $path)
    {
        $options = Injector::get('twig.config') ?? [];
        $this->loader = new Twig_Loader_Filesystem($path);
        $this->twig = new Twig_Environment($this->loader, $options);
        $this->twig->addExtension(new TwigExtensions);
    }

    /**
     *
     * @param string $namespace
     * @param string|null $path
     * @return void
     */
    public function addPath (string $namespace, ?string $path = null) : void
    {
        $this->loader->addPath($path, $namespace);
    }

    /**
     *
     * @param string $view
     * @param array $parameters
     * @return string
     */
    public function render (string $view, array $parameters = []) : string
    {
        return $this->twig->render($view, $parameters);
    }

    /**
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function addGlobal (string $name, $value) : void
    {
        $this->twig->addGlobal($name, $value);
    }
}
