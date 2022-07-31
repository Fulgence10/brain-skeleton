<?php

namespace Brain\Auth;

use Brain\Session\Session;
use Brain\DataBase\Entity\Entity;

class Authentication extends Entity
{
    private $session;

    private static $_instance = null;

    public function __construct()
    {
        $this->session = Session::getInstance();
    }

    /**
     *
     * @return self
     */
    public static function getInstance() : self
    {
        if(is_null(static::$_instance)) {
            static::$_instance = new Authentication();
        }
        return static::$_instance;
    }
    
    /**
     *
     * @return bool
     */
    public function check() : bool
    {
        return $this->session->has('_auth');
    }

    /**
     *
     * @return UserInterface
     */
    public function user() : ? UserInterface
    {
        return $this->session->get('_auth');
    }

    /**
     *
     * @param UserInterface $user
     * @return boolean
     */
    public function login(UserInterface $user) : bool
    {
        $this->session->set('_auth', $user);

        return true;
    }

    /**
     *
     * @return boolean
     */
    public function logout() : bool
    {
        $this->session->delete('_auth');

        return true;
    }
}