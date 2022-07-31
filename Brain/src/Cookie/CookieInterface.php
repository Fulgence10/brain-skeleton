<?php

namespace Brain\Cookie;

interface CookieInterface
{
    /**
     *
     * @param string $key
     * @return boolean
     */
    public function has (string $key) : bool;

    /**
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key, $default = null);
    
    /**
     *
     * @param string $key
     * @param mixed $value
     * @param integer $years
     * @return bool
     */
    public function set(string $key, $value, $years) : bool;

}
