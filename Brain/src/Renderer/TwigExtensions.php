<?php

namespace Brain\Renderer;

use Twig_Extension;
use Twig_SimpleFunction;
use Brain\Injector\Facade\Injector;
use Twig_SimpleFilter;

class TwigExtensions extends Twig_Extension
{
    /**
     *
     * @return array
     */
    public function getFunctions() : array
    {
        $func = [];
        $extensions = Injector::get('twig.functions');
        foreach ($extensions as $key => $ex) {
            $func[] = new Twig_SimpleFunction($key, $ex, ["is_safe" => ["html"]]);
        }
        return $func;
    }

    /**
     *
     * @return array
     */
    public function getFilters() : array
    {
        $func = [];
        $extensions = Injector::get('twig.filters');
        foreach ($extensions as $key => $ex) {
            $func[] = new Twig_SimpleFilter($key, $ex, ["is_safe" => ["html"]]);
        }
        return $func;
    }
}