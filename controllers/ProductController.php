<?php

namespace app\controllers;

use app\models\Product;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProductController extends Controller
{
    public function actionIndex($slug)
    {
        $model = Product::viewPage($slug);

        $this->view->params['category_ids'] = $model->category_ids;

        return $this->render('index', [
            'model' => $model,
        ]);
    }

}
