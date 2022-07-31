<?php

use App\Helpers;

return [
    /**
     * 
     * 
     * 
     */
    "template" => "twig",
    
    /**
     * 
     * 
     * 
     */
    "extension" => ".twig",

    /**
     * 
     * 
     * 
     */
    "path" => dirname(__DIR__) . "/templates/",

    /**
     * 
     * 
     * 
     * 
     * 
     */
    "twig.config" => [
        "debug" => true,
        "cache" => false
    ],

    /**
     * 
     * 
     * 
     */
    "twig.functions" => [
        
    ],

    /**
     * 
     * 
     * 
     */
    "twig.filters" => [
    ]
];
