<?php
/**
 * Database Connector Model Class
 *
 * @copyright   Copyright (c) 2018 (https://github.com/fatihcapak/Localization-Manager)
 * @author      Fatih ÇAPAK
 */

namespace App\Models\Database;

class Connector
{
    const DB_MASTER = 'master';
    const DB_SLAVE = 'slave';

    protected static $instance;
    protected static $selectedDb = [];
    protected $config;

    protected $connectionParams = [
        \PDO::ATTR_TIMEOUT => 10,
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
    ];

    /**
     * Connector constructor.
     */
    public function __construct()
    {
        $this->config = \App\Config::get('db');
        $this->config[static::DB_MASTER]['connectionString'] = sprintf("mysql:dbname=%s;host=%s:%s",
            $this->config[static::DB_MASTER]['dbName'], $this->config[static::DB_MASTER]['host'],
            $this->config[static::DB_MASTER]['port']);
        $this->config[static::DB_SLAVE]['connectionString'] = sprintf("mysql:dbname=%s;host=%s:%s",
            $this->config[static::DB_MASTER]['dbName'], $this->config[static::DB_MASTER]['host'],
            $this->config[static::DB_MASTER]['port']);
    }

    public static function getInstance()
    {
        if (static::$instance === null) {
            self::$instance =  new static();
        }

        return self::$instance;
    }

    /**
     * @return \PDO
     */
    protected function connect($db)
    {
        return new \PDO($this->config[$db]['connectionString'], $this->config[$db]['username'], $this->config[$db]['password'],
            $this->connectionParams
        );
    }

    /**
     * @return \PDO
     */
    public function useMaster()
    {
        if (empty(static::$selectedDb[static::DB_MASTER])) {
            static::$selectedDb[static::DB_MASTER] = $this->connect(static::DB_MASTER);
        }

        return static::$selectedDb[static::DB_MASTER];
    }

    /**
     * @return \PDO
     */
    public function useSlave()
    {
        if (empty(static::$selectedDb[static::DB_SLAVE])) {
            static::$selectedDb[static::DB_SLAVE] = $this->connect(static::DB_SLAVE);
        }

        return static::$selectedDb[static::DB_SLAVE];
    }
}
