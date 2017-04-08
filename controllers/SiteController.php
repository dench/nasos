<?php

namespace app\controllers;

use app\models\Category;
use dench\page\models\Page;
use Yii;
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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

            return $this->refresh();
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
}
