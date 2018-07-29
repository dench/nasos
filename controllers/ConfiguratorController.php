<?php

namespace app\controllers;

use app\models\QuestionnaireForm;
use dench\page\models\Page;
use Yii;
use yii\web\Controller;

class ConfiguratorController extends Controller
{
    public function actionIndex()
    {
        $page = Page::viewPage('configurator');

        $model = new QuestionnaireForm();

        if ($model->load(Yii::$app->request->post()) && $model->send()) {
            Yii::$app->session->setFlash('questionnaireFormSubmitted');
            return $this->refresh();
        }

        return $this->render('index', [
            'page' => $page,
            'model' => $model,
        ]);
    }

}
