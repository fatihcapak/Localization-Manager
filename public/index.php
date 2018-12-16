<?php
defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../App'));

date_default_timezone_set('Europe/Istanbul');

require '../vendor/autoload.php';

$boostrap = new \App\Models\Bootstrap(new \Slim\App([
    'settings' => [
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails'               => true,
    ]
]));
