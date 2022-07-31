<?php

namespace Brain\DataBase\Entity;

use Brain\DataBase\ORM\Model;

class Entity extends Model
{
    private $properties;

    /**
     *
     * @param array $param
     */
    public function __construct(array $param = []) 
    {
        parent::__construct();
      
        $this->properties = $param;
    }

    /**
     *
     * @return boolean
     */
    public function save() : bool 
    {  
       return $this->store($this->properties);
    }

    /**
     *
     * @param [type] $name
     * @return void
     */
    public function __get($name) 
    {
        return isset($this->properties[$name]) ? $this->properties[$name] : $this->{$name};
    }

    /**
     *
     * @param [type] $name
     * @param [type] $value
     */
    public function __set($name, $value)
    {
        $this->{$name} = $value;

        $this->properties[$name] = $value;
    }

}