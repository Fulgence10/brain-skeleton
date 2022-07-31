<?php

use Brain\Renderer\Renderer;
use Brain\Injector\Facade\Injector;

if(! function_exists('isAjax')) {
    /**
     *
     * @return boolean
     */
    function isAjax () : bool
    {
        $header = $_SERVER["HTTP_X_REQUESTED_WITH"];
        return !empty($header) && strtolower($header) === "xmlhttprequest";
    }
}

if(! function_exists('view')) {
    /**
     *
     * @param string $view
     * @param array $param
     * @return string
     */
    function view (string $view, array $param = []) : string
    {
       $renderer = Injector::get(Renderer::class); 
       return $renderer->render($view, $param);
    }
}

if(! function_exists('redirectTo')) {
    /**
     *
     * @param string $url
     * @return void
     */
    function redirectTo (string $url = "/") : void
    {
        header("Location: $url", true, 301);
        exit();
    }
}

if(! function_exists('redirectToOld')) {
    
    function redirectToOld () 
    {
        $refer = $_SERVER['HTTP_REFERER'];
        header("Location: $refer", true, 301);
        exit();
    }
}

if(! function_exists('path')) {
     
    function path (string $name, array $params = [])
    {
        $router = Injector::get(\Brain\Router\Router::class);
        return $router->url($name, $params);
    }
}


if(! function_exists('getHumainDate')) {
     
    function getHumainDate ($date)
    {
        $format = [
            "y" => 'ans',
            "m" => 'mois',
            "d" => 'jour(s)',
            "h" => 'heure(s)',
            "i" => 'minute(s)',
            "weekday" => 'semaine(s)',
        ];

        $date = new DateTime($date);
        $now = new DateTime();

        $out = null;
        $diff = $now->diff($date, 1);

        foreach ($diff as $key => $value) {
            if (is_null($out) && isset($format[$key])) {
                if ($value > 0) {
                    $out = "Il y'a $value $format[$key]";
                }else if ($key == 'i' && $value < 1) {
                    $out = "Il y'a un instant";
                }
            }
        }
        return $out;
    }
}

if(! function_exists('dd')) {
    /**
     * 
     *
     * @param array ...$args
     * @return void
     */
    function dd (...$args) : void
    {
        echo "<pre>";
            print_r(...$args);
        echo "</pre>";
        die();
    }
}
