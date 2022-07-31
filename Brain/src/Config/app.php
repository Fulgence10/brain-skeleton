<?php

use Brain\Session\Session;
use Brain\DataBase\QueryBuulder;
use Brain\Injector\Facade\Injector;

return [

    'brain.middleware' => [
        \Brain\Http\Middleware\RouteMiddleware::class,

        \Brain\Http\Middleware\CsrfMiddleware::class,

        \Brain\Http\Middleware\DispatcherMiddleware::class
    ],

    /**
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */
    Session::class => Injector::create(Session::class),
    /**
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */
    QueryBuulder::class => Injector::create(QueryBuulder::class)
                            ->constructor(DI\get(DBBuilder::class))

];
