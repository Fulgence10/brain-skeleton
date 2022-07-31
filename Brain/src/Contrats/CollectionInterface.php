<?php

namespace Brain\Contrats;

interface CollectionInterface {

    /**
     *
     * @param string $key
     * @param mixed $defaut
     * @return mixed
     */
    public function get($key, $defaut = null);


    /**
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value): void;


    /**
     *
     * @param string $key
     * @return boolean
     */
    public function has($key): bool;


    /**
     *
     * @param string $key
     * @return boolean
     */
    public function isEmpty($key): bool;

}