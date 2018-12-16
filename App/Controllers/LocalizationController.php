<?php

namespace App\Controllers;

class LocalizationController extends \App\Models\AbstractController
{
    public function editAction()
    {
        $error = false;
        $message = "";
        $localizationModel = new \App\Models\Localization();
        if (static::$app->getContainer()->request->isPost()) {
            $project = static::$app->getContainer()->request->getParam('project', null);
            $projectId = static::$app->getContainer()->request->getParam('projectId', null);
            $key = static::$app->getContainer()->request->getParam('key', null);
            $value = static::$app->getContainer()->request->getParam('value', null);
            $languageId = static::$app->getContainer()->request->getParam('languageId', null);
            $version = static::$app->getContainer()->request->getParam('version', null);
            $versionId = static::$app->getContainer()->request->getParam('versionId', null);

            if ((!$project && !$projectId) || !$key || !$value || !$languageId || (!$version && !$versionId)) {
                $error = true;
                $message = 'Error, please check all field';
            } else {
                try {
                    $params = [
                        'project'    => $project,
                        'projectId'  => $projectId,
                        'key'        => $key,
                        'value'      => $value,
                        'languageId' => $languageId,
                        'version'    => $version,
                        'versionId'  => $versionId,
                    ];

                    $localizationModel->addLocalization($params);
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
        $result = $localizationModel->getLocalizations($page);
        $count = $localizationModel->getLocalizationCount();

        $paginator = new \JasonGrimes\Paginator($count, $localizationModel::ITEM_PER_PAGE, $page, '/localization/edit?page=(:num)');
        $this->view->addAttribute('result', $result);
        $this->view->addAttribute('language', (new \App\Models\Language())->getAllLanguage());
        $this->view->addAttribute('version', (new \App\Models\Version())->getAllVersion());
        $this->view->addAttribute('project', (new \App\Models\Project())->getAllProject());
        $this->view->addAttribute('paginator', $paginator);
        $this->view->addAttribute('view', 'localization/edit');
        $this->view->addAttribute('error', $error);
        $this->view->addAttribute('message', $message);
        $this->render();
    }
}
