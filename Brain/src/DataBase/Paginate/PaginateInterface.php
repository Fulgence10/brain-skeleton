<?php

namespace Brain\DataBase\Paginate;

interface PaginateInterface
{
    public function paginate(int $page);

    public function totalPages() : int;
}
