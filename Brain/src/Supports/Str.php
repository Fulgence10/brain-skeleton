<?php

namespace Brain\Supports;

class Str
{
    /**
     *
     * @param string $str
     * @return string
     */
    public static function upper (string $str) : string
    {
        return strtoupper($str);
    }

    /**
     *
     * @param string $str
     * @return string
     */
    public static function lower (string $str) : string
    {
        return strtolower($str);
    }

    /**
    *
    * @param integer $char longeur de chaine
    * @return void
    */
    public static function generateStr(int $char)
    {
        $string = "";
        $chaine = "aLABbC0cEd1eDf2FghR3ij4kYXQl5Um";
        srand((double)microtime()*1000000);
        for($i=0; $i<$char; $i++) {
            $string .= $chaine[rand()%strlen($chaine)];
        }
        return $string;
    }
    
}
