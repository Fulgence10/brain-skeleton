<?php

namespace Brain\DataBase;

use PDO;
use Brain\Supports\Collection;
use Brain\Injector\Facade\Injector;
use Brain\DataBase\Connexion\MySqlAdapter;

class DataBase
{
    /**
     * Undocumented variable
     *
     * @var MySqlAdapter
     */
    private static $adapter;

    
    /**
     * Undocumented function
     *
     * @return void
     */
    public static function connexion (): void
    {
        $adapter_name = Injector::get('database');

        $config = Injector::get($adapter_name);

        static::$adapter = (new MySqlAdapter($config))->getConnexion();
    }


    /**
     * Undocumented function
     *
     * @return void
     */
    private static function verifyConnexion (): void
    {
        if(\is_null(static::$adapter)) {
            static::connexion();
        }
    }

    /**
     * Undocumented function
     *
     * @return PDO
     */
    public static function getAdapterConnexion ()
    {
        static::verifyConnexion();

        return static::$adapter;
    }

    /**
     *
     * @param string $stat
     * @param array $params
     * @return Collection
     */
    public static function query (string $stat, array $params = []): Collection
    {
        $query = static::getAdapterConnexion()->prepare($stat);

        $query->execute((array) $params);

        return new Collection($query->fetchAll(PDO::FETCH_ASSOC));
    }

    
}