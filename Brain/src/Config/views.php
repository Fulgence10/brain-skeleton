<?php

use Brain\Supports\Helpers;
use Brain\Renderer\Renderer;
use Brain\Renderer\PHPRenderer;
use Brain\Renderer\TwigRenderer;
use Brain\Injector\Facade\Injector;

return [
     /**
     * 
     * 
     * 
     */
    "twig.functions" => [
        
        "formatPrice" => [Helpers::getInstance(), 'formatPrice'],
        
        "formatDate" => [Helpers::getInstance(), 'formatDate'],

        "toNl2br" => [Helpers::getInstance(), 'toNl2br'],
        
        "path" => [Helpers::getInstance(), 'path'],
        
        "extract" => [Helpers::getInstance(), 'extract'],

        "csrf" => [Helpers::getInstance(), 'csrfInput'],

        "csrfValue" => [Helpers::getInstance(), 'csrfValue'],

        "flashed" => [Helpers::getInstance(), 'flashed'],

        "getHumainDate" => [Helpers::getInstance(), 'getHumainDate']
    ],
    
    PHPRenderer::class => Injector::create(PHPRenderer::class)
                                ->constructor(\DI\get("path")),
    Renderer::class => Injector::create(Renderer::class),

    TwigRenderer::class => Injector::create(TwigRenderer::class)
                                ->constructor(\DI\get("path"))
];
