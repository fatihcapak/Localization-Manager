<?php

namespace App\Models;

abstract class AbstractController
{
    /**
     * @var \Slim\App
     */
    public static $app;

    /**
     * @var \Slim\Views\PhpRenderer
     */
    public $view;

    /**
     * @var \App\Models\Entities\User
     */
    public $currentUser;

    /**
     * AbstractController constructor.
     */
    public function __construct()
    {
        session_start();
        $container['session'] = function ($container) {
            return new \SlimSession\Helper;
        };

        $container = static::$app->getContainer();
        $container['view'] = function ($container) {
            return new \Slim\Views\PhpRenderer(APPLICATION_PATH . '/Views/layout');
        };

        $this->view = static::$app->getContainer()->view;

        $this->currentUser = (new \App\Models\User())->getCurrentUser();
        if (!$this->currentUser instanceof \App\Models\Entities\User) {
            if ($container->request->getParam('q') !== '/user/login') {
                header('Location: /user/login', true, 303);
                exit;
            }
        } else {
            if ($container->request->getParam('q') == '/user/login') {
                header('Location: /', true, 303);
                exit;
            }
        }
    }

    protected function render($layout = 'layout.phtml')
    {
        $this->view->render(static::$app->getContainer()->response, $layout);
    }

    protected function writeJson($data)
    {
        header("Content-Type: application/json");
        echo json_encode($data);
        die;
    }
}
