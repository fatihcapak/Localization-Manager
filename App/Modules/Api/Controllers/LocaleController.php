<?php

namespace App\Modules\Api\Controllers;

class LocaleController
{
    public function getLocaleAction()
    {
        $project = \App\Models\AbstractController::$app->getContainer()->request->getParam('project', null);
        $language = \App\Models\AbstractController::$app->getContainer()->request->getParam('language', null);
        $version = \App\Models\AbstractController::$app->getContainer()->request->getParam('version', null);

        if (!$project || !$language || !$version) {
            return (new \Slim\Http\Response())->withJson((new \App\Models\Response\ErrorResponse(100, 'Please check all params')), 400);
        }

        $result = (new \App\Models\Localization())->getLocale($project, $language, $version);
        return (new \Slim\Http\Response())->withJson((new \App\Models\Response\DefaultResponse($result)));
    }
}
