<?php
/**
 * Bootstrap Model Class
 *
 * @copyright   Copyright (c) 2018 (https://github.com/fatihcapak/Localization-Manager)
 * @author      Fatih ÇAPAK
 */

namespace App\Models;


class Bootstrap
{
    /**
     * Bootstrap constructor.
     * @param \Slim\App $app
     */
    public function __construct($app)
    {
        AbstractController::$app = $app;
        $this->registerRoutes();
        AbstractController::$app->run();
    }

    public function registerRoutes()
    {
        $app = AbstractController::$app;
        $app->get('/', 'App\Controllers\IndexController:indexAction');

        $app->group('/user', function () use ($app) {
            $app->get('/login', 'App\Controllers\UserController:loginAction');
            $app->post('/login', 'App\Controllers\UserController:loginAction');
            $app->get('/logout', 'App\Controllers\UserController:logoutAction');
            $app->get('/edit', 'App\Controllers\UserController:editAction');
            $app->post('/edit', 'App\Controllers\UserController:editAction');
        });

        $app->group('/localization', function () use ($app) {
            $app->get('/edit', 'App\Controllers\LocalizationController:editAction');
            $app->post('/edit', 'App\Controllers\LocalizationController:editAction');
        });

        $app->group('/api', function () use ($app) {
            $app->get('/locale',
                'App\Modules\Api\Controllers\LocaleController:getLocaleAction');
        });
    }
}
