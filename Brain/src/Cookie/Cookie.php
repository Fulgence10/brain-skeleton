<?php

namespace Brain\Cookie;

class Cookie implements CookieInterface
{
     /**
     *
     * @var Cookie
     */
    private static $_instance;


    /**
     *
     * @return Cookie
     */
    public static function getInstance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new Cookie();
        }
        return self::$_instance;
    }

    /**
     *
     * @param string $key
     * @return boolean
     */
    public function has (string $key) : bool
    {
        return isset($_COOKIE[$key]);
    }

    /**
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->has($key) ? $_COOKIE[$key] : $default;
    }
    
    /**
     *
     * @param string $key
     * @param mixed $value
     * @param integer $years
     * @return bool
     */
    public function set(string $key, $value, $years = 1) : bool
    {
        return setcookie(
            $key, $value, 
            time() + ((365*24*3600) * $years), 
            null, null, 
            false, true
        );
    }

}
