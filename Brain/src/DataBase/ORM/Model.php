<?php

namespace Brain\DataBase\ORM;

use Brain\DataBase\DataBase;
use Brain\Supports\Collection;
use Brain\DataBase\ORM\Builder;

abstract class Model
{
    protected $builder;

    public function __construct() {

        $this->builder = null;

    }
    
    /**
     *
     * @param array $columns
     * @return Builder
     */
    public function select(array $columns = ['*']) : Builder
    {
        $static = $this->query();

        if (count($columns) > 0) {
            $static->select($columns);
        }
        
        return $static;
    }

    /**
     *
     * @param array $columns
     * @return Collection
     */
    public function all(array $columns = []) : Collection
    {
        $static = $this->query();

        if (count($columns) > 0) {
            $static->select($columns);
        }

        return new Collection($static->execute());
    }


    /**
     *
     * @param array $condition
     * @return bool
     */
    public function delete(array $condition = []) : bool
    {
        $static = $this->query();

        $static->delete($condition);

        return $static->execute();
    }

    /**
     *
     * @param string $key
     * @param mixed $param
     * @return object
     */
    public function find(string $key, $param) 
    {
        return $this->query()->select()->where([
            $key => $param
        ])->first();
    }

    /**
     *
     * @return static
     */
    public function first()
    {
        return $this->query()->first();
    }

    /**
     *
     * @param array $parameters
     * @return boolean
     */
    public function store($parameters = []) : bool
    {
        return $this->query()->insert(array_keys($parameters))
                             ->flush($parameters);
    }

    /**
     *
     * @param array $parameters
     * @return boolean
     */
    public function update($parameters = [], $conditions = []) : bool
    {
        return $this->query()->update(array_keys($parameters), $conditions)
                             ->flush($parameters);
    }

    /**
     * Undocumented function
     *
     * @return Builder
     */
    private function query(): Builder
    {
        if($this->builder instanceof Builder) {
            return $this->builder;
        }

        $table = explode('\\',  static::class);
        $table = end($table);
        $table = strtolower($table.'s');

        $this->builder = new Builder(
            $table, 
            DataBase::getAdapterConnexion(),
            static::class
        );

        return $this->builder;
    }

}
