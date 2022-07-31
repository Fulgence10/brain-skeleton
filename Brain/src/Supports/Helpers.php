<?php

namespace Brain\Supports;

use DateTime;
use Brain\Injector\Facade\Injector;
use Brain\Http\Middleware\CsrfMiddleware;
use Brain\Services\FlashService;

class Helpers {

    private static $instance;

    private $token;

    /**
     *
     * @return self
     */
    public static function getInstance () : self
    { 
       if(! static::$instance) {
            static::$instance = new Helpers;
       }
       return static::$instance;
    }

    /**
     *
     * @param string $str
     * @return string
     */
    public function flashed ($key)
    { 
        $flashed = Injector::get(FlashService::class);

        return $flashed->get($key);
    }

    /**
     *
     * @param string $str
     * @return string
     */
    public function csrfInput () : string
    { 
        $csrfClass = Injector::get(CsrfMiddleware::class);

        $key = $csrfClass->getFormKey();
        $this->token = $csrfClass->generateTokenCsrf(50);

        return '<input type="hidden" name="'.$key.'" value="'.$this->token.'"/>';
    }
    
    /**
     *
     * @param string $str
     * @return string
     */
    public function csrfValue () : ?string
    { 
        $csrfClass = Injector::get(CsrfMiddleware::class);
        return $csrfClass->generateTokenCsrf(50);
    }

    /**
     *
     * @param [type] $p
     * @return void
     */
    public function formatPrice ($p) 
    { 
        return number_format(
            floatval($p), 
            0, 
            '.', 
            ' '
        ) . ' FCFA';
    }

    /**
     *
     * @param [type] $p
     * @return void
     */
    public function formatDate ($date) 
    { 
        return (new DateTime($date))->format('d F Y H:m:i');
    }

    /**
     *
     * @param [type] $p
     * @return void
     */
    public function toNl2br ($txt) 
    { 
        return nl2br($txt);
    }

    /**
     *
     * @param string $str
     * @return string
     */
    public function extract (string $str, int $limit = 30) : string
    { 
        if(strlen($str) < 30) {
            return $str;
        }
        return substr($str, 0, $limit) . '...';
    }


    /**
     *
     * @param string $key
     * @param array $param
     * @return string
     */
    public function path (string $key, array $params = []) : ?string
    { 
        return path($key, $params);
    }

    /**
     *
     * @param string $key
     * @param array $param
     * @return array
     */
    public static function securityForm (array $data = []) : array
    { 
        foreach ($data as $key => $value) {
            $data[$key] = htmlspecialchars($value);
        }
        return $data;
    }

    /**
     * 
     * 
     * 
     */
    public function getHumainDate (string $date)
    {
        return getHumainDate($date);
    }


}
