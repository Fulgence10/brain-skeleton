<?php

namespace Brain\Http\Middleware;

use Brain\Exception\CsrfException;
use Brain\Session\Session;
use Brain\Session\SessionInterface;
use Brain\Supports\Str;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CsrfMiddleware implements MiddlewareInterface
{
    private string $formKey = "__csrf";

    private string $sessionKey = "brain.csrf";

    private SessionInterface $session;

    public function __construct()
    {
        $this->session = Session::getInstance();
    }

    /**
     * Undocumented function
     *
     * @param ServerRequestInterface $request
     * @param [type] $next
     * @return ResponseInterface
     */
    public function delegate (ServerRequestInterface $request, $next) : ResponseInterface
    {
        if(in_array($request->getMethod(), ['POST', 'PUT', 'DELETE'])) {
            $parameters = $request->getParsedBody() ?? [];
            $csrfList = $this->getCsrfList();
            if(
                array_key_exists($this->formKey, $parameters) &&
                in_array($parameters[$this->formKey], $csrfList)
            ) {
                // $this->useTokent($parameters[$this->formKey]);
                return $next($request);
            } else {
                $this->reject();
            }
        }
        return $next($request);
    }

    /**
     * Get the value of formKey
     */ 
    public function getFormKey()
    {
        return $this->formKey;
    }

    /**
     *
     * @param integer $len
     * @return string
     */
    public function generateTokenCsrf (int $len) : string
    {
        $token = Str::generateStr($len);
        $csrfList = $this->getCsrfList();

        $csrfList[] = $token;
        $this->setCsrfList($csrfList);

        $this->limitToken();

        return (string) $token;
    }

    /**
     * 
     *
     * @return void
     */
    private function limitToken () : void
    {
        $csrfList = $this->getCsrfList();
        if(count($csrfList) > 100) {
            \array_shift($csrfList);
        }
        $this->setCsrfList($csrfList);
    }

    /**
     * 
     *
     * @return array
     */
    private function getCsrfList () : array
    {
        return $this->session->get($this->sessionKey, []);
    }

    /**
     *
     * @param array $v
     * @return void
     */
    private function setCsrfList (array $v) : void
    {
        $this->session->set($this->sessionKey, $v);;
    }

    /**
     * 
     *
     * @return void
     */
    private function reject () : void
    {
        throw new CsrfException("Token manquant ou invalide", 419);
    }

    /**
     * Get the value of formKey
     */ 
    // private function useTokent(string $token) : void
    // {
    //     $csrfList = array_filter($this->getCsrfList(), function ($t) use($token) {
    //         return $token !== $t;
    //     });
    //     $this->setCsrfList($csrfList);
    // }

    
}
