<?php

namespace Brain\DataBase;

use PDO;

class QueryBuilder
{
    protected $connexion;

    protected $sqlBegine;

    protected $table;

    protected $entity;
    
    protected $first;

    private $select;

    private $where;

    private $insertSql;

    private $updateSql;

    private $limit;

    private $order;

    private $likes;

    private $innerJoin;

    private $offset;

    private $whereParameters = [];
    
    /**
     * Undocumented function
     *
     * @param string $table
     * @param PDO $connexion
     */
    public function __construct(string $table, PDO $connexion, ?string $entity) 
    {
        $this->connexion = $connexion;

        $this->table = $table;

        $this->entity = $entity;

        $this->sqlBegine = 'SELECT';
    }

    /**
     * Undocumented function
     *
     * @return static
     */
    public function first() 
    {
        $this->first = true;

        return $this->execute();
    }
    
    /**
     * Undocumented function
     *
     * @return static
     */
    public function offset(int $value = null) 
    {
        $this->offset = $value;

        return $this;
    }
    
    /**
     * Undocumented function
     *
     * @param integer $limit
     * @return static
     */
    public function limit(int $limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param integer $limit
     * @return static
     */
    public function orderBy(string $key, string $direction = 'ASC')
    {
        $direction = strtoupper($direction);
        if(in_array($direction, ['ASC', 'DESC'])) {
            $this->order = [$key, $direction];
        } 
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param array $likes
     * @return static
     */
    public function likes(string $key , string $value)
    {
        $this->likes = " WHERE $key LIKE :$key";
        
        $this->whereParameters[$key] = '%'.$value.'%';
    
        return $this;
    }

    /**
     *
     * @param array $column
     * @return self
     */
    public function select(array $column = ['*']) : self
    {
        $this->sqlBegine = 'SELECT';

        $this->select = implode(', ', $column);
        
        return $this;
    }

    /**
     *
     * @param string $key
     * @return self
     */
    public function count(string $key) : self
    {
        $this->sqlBegine = 'SELECT';

        $this->select = "COUNT($key)";
        
        return $this;
    }

    /**
     *
     * @param array $condition
     * @return self
     */
    public function delete(array $condition = []) : self
    {
        $this->sqlBegine = 'DELETE';
        
        return $this->where($condition);
    }

    /**
     *
     * @param string $t table
     * @param array $cd
     * @return self
     */
    public function innerJoin(string $t, array $cd = []) : self
    {
        $innerJoin = null;
        foreach ($cd as $key => $value) {
            if(is_null($innerJoin)) {
                $innerJoin = "INNER JOIN $t ON $key = $value";
            } else {
                $innerJoin .= " AND $key = $value";
            }
        }
        $this->innerJoin .= " " . $innerJoin;

        return $this;
    }

    /**
     *
     * @param array $column
     * @return self
     */
    public function insert(array $columns = []) : self
    {
        $this->insertSql = "INSERT INTO $this->table(".implode(', ', $columns) .")";

        $this->insertSql .= " VALUES(";
        
        foreach ($columns as $value) {
            $this->insertSql .= ":$value, ";
        }
        $this->insertSql = trim($this->insertSql, ', ') . ")";

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param array $columns
     * @param array $conditions
     * @return self
     */
    public function update(array $columns = [], $conditions = []) : self
    {
        $this->updateSql = "UPDATE $this->table SET ";
        
        foreach ($columns as $value) {
            $this->updateSql .= "$value=:$value, ";
        }

        $this->updateSql = trim($this->updateSql, ', ');

        if(! empty($conditions)) {
            $this->where($conditions);
            
            $this->updateSql .= ' WHERE ' . $this->where;

            $this->where = null;
        }

        return $this;
    }

    /**
     *
     * @param array $params
     * @return boolean
     */
    public function flush(array $params = []) : bool
    {
        $params = array_merge($params, $this->whereParameters);

        if(! empty($this->insertSql)) {
            return $this->getSQLResults($this->insertSql, $params);
        }

        if(! empty($this->updateSql)) {
            return $this->getSQLResults($this->updateSql, $params);
        }
        return false;
    }


    /**
     *
     * @param array $condition
     * @param string $sp
     * @return self
     */
    public function where(array $condition = [], string $sp = ' AND ') : self
    {
        if(! empty($condition)) {
             $this->whereParameters = array_merge($this->whereParameters, $condition);
            foreach ($condition as $key => $value) {
                if(is_null($this->where)) {
                    $this->where = $key . '=:' . $key;
                } else {
                    $this->where .= $sp . $key . '=:' . $key;
                }
            }
        }
        
        return $this;
    }

    /**
     *
     * @param array $condition
     * @param string $sp
     * @return self
     */
    public function orWhere(array $condition = []) : self
    {
        $this->where($condition, ' OR ');
        
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    private function toSQL() : string
    {
        $sql = $this->sqlBegine;
    
        if($this->sqlBegine == 'SELECT') {
            if(empty($this->select)) {
                $sql .=  ' * ';
            } else {
                $sql .=  ' ' . $this->select;
            }
        }
        
        $sql .= ' FROM ' . $this->table;

        // Ajout de la clause inner join
        if(! is_null($this->innerJoin) ) {
            $sql .= $this->innerJoin;

            $this->innerJoin = null;
        } 

        // Ajout de la clause where
        if(! is_null($this->where)) {
            $sql .= ' WHERE ' . $this->where;
            $this->where = null;
        } 
        
        // Ajout de la clause like
        if (!is_null($this->likes)) {
            $sql .= $this->likes;
            $this->likes = null;
        }

        // Ajout de la clause order
        if (!is_null($this->order)) {
            $sql .= ' ORDER BY ' . implode(' ', $this->order);
            $this->order = null;
        }

        // Ajout de la clause limit
        if (!is_null($this->limit)) {
            $sql .= ' LIMIT ' . $this->limit;
            $this->limit = null;
        }

        // Ajout de la clause offset
        if (!is_null($this->offset)) {
            $sql .= ' OFFSET ' . $this->offset;
            $this->offset = null;
        }

        return $sql;
    }

     
    /**
     *
     * @return mixed
     */
    public function execute() 
    {
        $sql = $this->toSQL();

        $params = $this->whereParameters;

        $this->whereParameters = [];

        return $this->getSQLResults($sql, $params);
    }

    /**
     *
     * @param string $sql
     * @return boolean
     */
    public function getSQLResults(string $sql, array $params = [])
    {
        $stm = $this->connexion->prepare($sql);
        $data = $stm->execute($params);

        if($this->exceptionFetch($sql)) {
            $this->sqlBegine = 'SELECT';
            $stm->closeCursor();
            return $data;
        }

        if(! is_null($this->entity)) {
            $data = $stm->fetchAll(PDO::FETCH_CLASS, $this->entity);
        } else {
            $data = $stm->fetchAll(PDO::FETCH_OBJ);
        }

        $stm->closeCursor();

        if(! $this->first) {
            return $data;
        }

        $this->first = false;
        
        return current($data);
    }

    /**
     *
     * @param string $stm
     * @return boolean
     */
    private function exceptionFetch(string $stm) : bool
    {
        return (
            strpos($stm, 'DELETE') === 0 ||
            strpos($stm, 'UPDATE') === 0 ||
            strpos($stm, 'INSERT') === 0
        );
    }

   
}
