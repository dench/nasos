<?php

namespace app\controllers;

use app\models\CallbackForm;
use app\models\Category;
use dench\page\models\Page;
use Yii;
use yii\data\ActiveDataProvider;
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

        $categories = !Yii::$app->cache->exists('_categories-' . Yii::$app->language) ? Category::getMain() : [];

        $info = Page::findOne(5);

        $dataProvider = new ActiveDataProvider([
            'query' => $info->getChilds()->where(['enabled' => 1])->limit(2),
            'sort'=> [
                'defaultOrder' => [
                    'position' => SORT_ASC,
                ],
            ],
            'pagination' => false,
        ]);

        return $this->render('index', [
            'page' => $page,
            'categories' => $categories,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContacts()
    {
        $page = Page::viewPage(4);

        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->redirect(Url::current(['#' => 'feedback']));
        }
        return $this->render('contacts', [
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
