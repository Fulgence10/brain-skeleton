<?php

namespace Brain\Event;

interface EventInterface
{
    /**
    * Get $name
    * @return string
    */
    public function getName(): string;

    /**
    * Get $target
    */
    public function getTarget();

    /**
    * Get $params
    */
    public function getParams();

    /**
    * Get $params
    */
    public function getParam($name);

    /**
    * Set $name
    * @param string $name
    */
    public function setName(string $name);

    /**
    * Set $target
    */
    public function setTarget($target);

    /**
    * Set $params
    */
    public function setParams($params);

    /**
     * 
    */
    public function isStopPropagation($flag);

    /**
     * 
    */
    public function isPropagationStoped();
}
