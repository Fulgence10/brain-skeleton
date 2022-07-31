<?php

namespace Brain\DataBase\Paginate;

use App\Exceptions\NotFoundException;

class PagerBrain implements PaginateInterface
{
    private int $perPage;

    private int $totalPages;

    private $statement;

    /**
     * 
     * 
     */
    public function __construct($statement, int $perPage = 10)
    {
        $this->perPage = $perPage;

        $this->statement = $statement;

        $query = clone $statement;
        
        $this->totalPages = ceil(count($query->execute()) / $this->perPage);

    }

    /**
     * 
     * 
     * 
     */
    public function paginate(int $page = 1)
    { 
        if($page < 0) {
            throw new NotFoundException("Numéro de page invalide :(", 404);
            exit();
        };

        $statement = clone $this->statement;

        $data =  $statement
                ->limit($this->perPage)
                ->offset($this->perPage * ($page - 1))
                ->execute();
        
        if(! $data) {
            throw new NotFoundException("Cette page n'existe pas :(", 404);
            exit();
        }

        return $data;
    }
    

    /**
     * Get the value of totalPages
     */ 
    public function totalPages() : int
    {
        return $this->totalPages;
    }

    /**
    * Set $totalPages
    * @param int $totalPages
    */
    public function setTotalPages(int $totalPages)
    {
        $this->totalPages = $totalPages;
    }
}
