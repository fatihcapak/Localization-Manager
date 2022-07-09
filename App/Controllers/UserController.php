<?php

namespace App\Controllers;

class UserController extends \App\Models\AbstractController
{
    public function loginAction()
    {
        if (static::$app->getContainer()->request->isPost()) {
            $username = static::$app->getContainer()->request->getParam('username', null);
            $password = static::$app->getContainer()->request->getParam('password', null);

            if (!$username || !$password) {
                $this->view->addAttribute('error', 'Empty field');
            } else {
                $userModel = new \App\Models\User();

                if ($userModel->login($username, $password)) {
                    header('Location: /', true, 303);
                    exit;
                }
            }
        }

        $this->view->addAttribute('view', 'user/login');
        $this->view->addAttribute('disableLayout', true);
        $this->render();
    }

    public function logoutAction()
    {
        (new \App\Models\User())->logout();
        header('Location: /user/login');
    }

    public function editAction()
    {
        if ($this->currentUser->getRole() != 1) {
            header('Location: /');
            exit;
        }

        $error = false;
        $message = "";

        $userModel = new \App\Models\User();
        if (static::$app->getContainer()->request->isPost()) {
            $id = static::$app->getContainer()->request->getParam('id', null);
            $username = static::$app->getContainer()->request->getParam('username', null);
            $password = static::$app->getContainer()->request->getParam('password', null);
            $role = static::$app->getContainer()->request->getParam('role', null);

            if (!$username || (!$id && !$password) || !is_numeric($role)) {
                $error = true;
                $message = 'Error, please check all field';
            } else {
                try {
                    if ($id) {
                        $userModel->updateUser($id, $username, $password, $role);
                    } else {
                        $userModel->addUser($username, $password, $role);
                    }

                    $message = 'Successful';
                } catch (\UnexpectedValueException $uex) {
                    $error = true;
                    $message = 'Error, please check all field';
                } catch (\Exception $e) {
                    $error = true;
                    $message = 'Error, please try later';
                }
            }
        }

        $page = static::$app->getContainer()->request->getParam('page', 1);
        $result = $userModel->getUsers($page);
        $count = $userModel->getUserCount();

        $paginator = new \JasonGrimes\Paginator($count, $userModel::ITEM_PER_PAGE, $page, '/user/edit?page=(:num)');
        $this->view->addAttribute('result', $result);
        $this->view->addAttribute('paginator', $paginator);
        $this->view->addAttribute('view', 'user/edit');
        $this->view->addAttribute('error', $error);
        $this->view->addAttribute('message', $message);
        $this->render();
    }
}
