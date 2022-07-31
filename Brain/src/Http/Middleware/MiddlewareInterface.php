<?php

namespace Brain\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;

interface MiddlewareInterface
{
    public function delegate(ServerRequestInterface $resquest, $next);
}