<?php

namespace Brain\Supports;

use ArrayAccess;
use ArrayIterator;
use Brain\Contrats\CollectionInterface;
use IteratorAggregate;

class Collection implements CollectionInterface, ArrayAccess, IteratorAggregate
{
    private array $items;

    /**
     *
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     *
     * @param string $key
     * @param mixed $defaut
     * @return mixed
     */
    public function get($key, $defaut = null)
    {
        if($this->has($key)) {
            return $this->items[$key];
        }
        return $defaut;
    }

    /**
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value): void
    {
        $this->items[$key] = $value;
    }

    /**
     *
     * @param string $key
     * @return boolean
     */
    public function has($key): bool
    {
        return array_key_exists($key, $this->items);
    }

    /**
     *
     * @param string $key
     * @return boolean
     */
    public function isEmpty($key): bool
    {
        return empty($this->items);
    }

    /**
     *
     * @param [type] $cb
     * @return void
     */
    public function each(callable $cb)
    {
        foreach ($this->items as $key => $value) {
            call_user_func_array($cb, [$key, $value]);
        }
    }


    /**
     *
     * @return void
     */
    public function first()
    {
        return current($this->items);
    }

    /**
     *
     * @param [type] $offset
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     *
     * @param [type] $offset
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }
    
    /**
     *
     * @param [type] $offset
     * @param [type] $value
     */
    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    /**
     *
     * @param [type] $offset
     * @return void
     */
    public function offsetUnset($offset) : void
    {
        unset($this->items[$offset]);
    }

    /**
     *
     * @return ArrayIterator
     */
    public function getIterator() : ArrayIterator
    {
        return new ArrayIterator($this->items);
    }
    
}
