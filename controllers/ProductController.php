<?php

namespace app\controllers;

use app\models\Product;
use app\models\ProductSearch;
use dench\block\traits\BlockTrait;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProductController extends Controller
{
    use BlockTrait;

    public function actionIndex($slug)
    {
        $model = Product::viewPage($slug);

        if (!$model->enabled) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

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
        $similar = Product::find()->where(['id' => $viewed_ids])->all();
        /* End - Save viewed products */

        /**
         * Similar products
         */
        if (count($similar) < 1) {
            $viewed = 0;
            $similar = Product::find()->joinWith(['categories'])->where(['product.enabled' => 1, 'category_id' => $model->category_ids[0]])->limit(6)->all();
        } else {
            $viewed = 1;
        }
        /* Similar products */

        $view = 'index';

        if ($model->view) {
            $view = $model->view;
        }

        return $this->render($view, [
            'model' => $model,
            'viewed' => $viewed,
            'similar' => $similar,
        ]);
    }

}
