<?php
/**
 * Config Model Class
 *
 * @copyright   Copyright (c) 2018 (https://github.com/fatihcapak/Localization-Manager)
 * @author      Fatih ÇAPAK
 */

namespace App;

class Config
{
    private static $configData = [
        'db' => [
            \App\Models\Database\Connector::DB_MASTER => [
                'dbName'   => 'dbName',
                'host'     => 'localhost',
                'port'     => '3306',
                'username' => 'root',
                'password' => '',
            ],
            \App\Models\Database\Connector::DB_SLAVE  => [
                'dbName'   => 'dbName',
                'host'     => 'localhost',
                'port'     => '3306',
                'username' => 'root',
                'password' => '',
            ]
        ]
    ];

    public static function get($name)
    {
        return static::$configData[$name];
    }
}
