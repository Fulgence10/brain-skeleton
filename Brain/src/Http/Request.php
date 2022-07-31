<?php

namespace Brain\Http;

use Brain\Cookie\Cookie;
use Brain\Session\Session;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;

class Request extends ServerRequest implements ServerRequestInterface
{
    /**
     *
     * @return Session
     */
    public function getSession() : Session
    {
        return Session::getInstance();
    } 

    /**
     *
     * @return Cookie
     */
    public function getCookie() : Cookie
    {
        return Cookie::getInstance();
    }    
}
