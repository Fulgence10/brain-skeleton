<?php

namespace Brain\Event;

class Event implements EventInterface
{
    private string $name;
      
    private $target;
    
    private array $params = [];

    private bool $propagationStoped = false;


    /**
    * Get $name
    * @return string
    */
    public function getName(): string
    {
        return $this->name;
    }

    /**
    * Get $target
    */
    public function getTarget()
    {
        return $this->target;
    }

    /**
    * Get $params
    */
    public function getParams()
    {
        return $this->params;
    }

    /**
    * Get $params
    */
    public function getParam($name)
    {
        return $this->params[$name] ?? null;
    }

    /**
    * Set $name
    * @param string $name
    */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
    * Set $target
    */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
    * Set $params
    */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * 
    */
    public function isStopPropagation($flag)
    {
        $this->propagationStoped = $flag;
    }

    /**
     * 
    */
    public function isPropagationStoped()
    {
        return $this->propagationStoped;
    }

}
