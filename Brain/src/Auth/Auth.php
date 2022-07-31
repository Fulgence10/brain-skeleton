<?php

namespace Brain\Auth;


class Auth
{
    /**
     *
     * @param string $name
     * @param array $arguments
     * @return void
     */
    public static function __callStatic(string $name, array $arguments = [])
    {
        return \call_user_func_array(
            [Authentication::getInstance(), $name], 
            $arguments
        );
    }

}