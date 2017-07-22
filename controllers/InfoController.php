<?php

namespace app\controllers;

use dench\page\models\Page;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class InfoController extends \yii\web\Controller
{
    private $_id = 5;

    public function actionIndex()
    {
        $page = Page::viewPage($this->_id);

        $dataProvider = new ActiveDataProvider([
            'query' => $page->getChilds()->where(['enabled' => 1]),
            'sort'=> [
                'defaultOrder' => [
                    'position' => SORT_ASC,
                ],
            ],
            'pagination' => [
                'defaultPageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'page' => $page,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($slug)
    {
        $page = Page::viewPage($slug);

        if (!in_array($this->_id, $page->parent_ids) || !$page->enabled) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('view', [
            'page' => $page,
        ]);
    }
}
