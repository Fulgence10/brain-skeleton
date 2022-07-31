<?php

namespace Brain\Services;

use Brain\Session\Session;

class FlashService 
{
    /**
     *
     * @var Session
     */
    private Session $session;

    private array $message = [];

    
    public function __construct(Session $session)
    {
        $this->session = $session;   
    }

    /**
     * 
     * 
     * 
     * 
     */
    public function get(string $key)
    {
        if($this->session->has($key)) {
            $this->message[$key] = $this->session->get($key, null);
            $this->session->delete($key);
        }
        return $this->message[$key] ?? null;
    }

    /**
     * 
     * 
     * 
     */
    public function set(string $key, $value)
    {
        $value = $this->session->set($key, $value);
    }
}
