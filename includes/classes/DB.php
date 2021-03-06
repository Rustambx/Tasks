<?php

namespace Task;

class DB
{
    private static $qb = null;

    /**
     * Соединение в базу данных
     * @return bool|\Pixie\QueryBuilder\QueryBuilderHandler|null
     * @throws \Pixie\Exception
     */
    public static function getConnection ()
    {
        $config = array(
            'driver'    => 'mysql', // Db driver
            'host'      => DB_HOST,
            'database'  => DB_NAME,
            'username'  => DB_USER,
            'password'  => DB_PASSWORD,
            'charset'   => 'utf8', // Optional
            'collation' => 'utf8_unicode_ci', // Optional
        );

        $connection = new \Pixie\Connection('mysql', $config);;
        if (self::$qb == null) {
            self::$qb = new \Pixie\QueryBuilder\QueryBuilderHandler($connection);
            if (self::$qb == false) {
                echo 'Ошибка: Невозможно подключиться к MySQL';
                return false;
            }
        }
        return self::$qb;
    }
}