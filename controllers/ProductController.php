<?php

namespace app\controllers;

use app\models\Product;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProductController extends Controller
{
    public function actionIndex($slug)
    {
        $model = Product::viewPage($slug);

        $this->view->params['category_ids'] = $model->category_ids;

        /**
         * Save viewed products
         */
        $viewed_ids = Yii::$app->request->cookies->getValue('viewed_ids','a:0:{}');
        $viewed_ids = unserialize($viewed_ids);
        array_unshift($viewed_ids, $model->id);
        $viewed_ids = array_unique($viewed_ids);
        $viewed_ids = array_slice($viewed_ids,  0, 7);
        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'viewed_ids',
            'value' => serialize($viewed_ids),
            'expire' => time()+3600*24*30
        ]));
        $viewed_ids = array_diff($viewed_ids, [$model->id]);
        $viewed = Product::find()->where(['id' => $viewed_ids])->all();
        /* End - Save viewed products */

        $view = 'index';

        if ($model->view) {
            $view = $model->view;
        }

        return $this->render($view, [
            'model' => $model,
            'viewed' => $viewed,
        ]);
    }

}
