<?php
error_reporting (-1);
defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../App'));
require APPLICATION_PATH . '/../vendor/autoload.php';
$config = \App\Config::get('db')[\App\Models\Database\Connector::DB_MASTER];

$db = new mysqli($config['host'], $config['username'], $config['password'], $config['dbName']);
$import = new MySQLImport($db);
$import->load(APPLICATION_PATH . '/../sqlDump/data.sql');
echo "Dumping successful";
