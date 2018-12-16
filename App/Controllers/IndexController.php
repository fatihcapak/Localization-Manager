<?php

namespace App\Controllers;

class IndexController extends \App\Models\AbstractController
{
    public function indexAction()
    {
        $userModel = new \App\Models\User();
        $localizationModel = new \App\Models\Localization();

        $userCount = $userModel->getUserCount();
        $localizationCount = $localizationModel->getLocalizationCount();

        $this->view->addAttribute('userCount', $userCount);
        $this->view->addAttribute('localizationCount', $localizationCount);
        $this->view->addAttribute('view', 'index/index');
        $this->render();
    }
}
