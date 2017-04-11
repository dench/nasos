<?php

namespace app\controllers;

use app\models\CallbackForm;
use app\models\Category;
use dench\page\models\Page;
use Yii;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $page = Page::viewPage(1);

        $categories = Category::getMain();

        return $this->render('index', [
            'page' => $page,
            'categories' => $categories,
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $page = Page::viewPage(4);

        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->redirect(Url::current(['#' => 'feedback']));
        }
        return $this->render('contact', [
            'page' => $page,
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        $page = Page::viewPage(3);

        return $this->render('about', [
            'page' => $page,
        ]);
    }

    /**
     * @return string
     */
    public function actionCallback()
    {
        $model = new CallbackForm();

        if ($model->load(Yii::$app->request->post()) && $model->send(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return 'success';
        }
        return $this->renderAjax('callback', [
            'model' => $model,
        ]);
    }
}
