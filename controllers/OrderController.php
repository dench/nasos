<?php

namespace app\controllers;

use dench\cart\models\Order;
use dench\page\models\Page;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class OrderController extends Controller
{
    /**
     * @param $id
     * @param $hash
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionIndex($id, $hash)
    {
        $page = Page::viewPage('order');

        $order = Order::findOne($id);

        if ($hash !== md5($id . Yii::$app->params['order_secret'])) {
            //throw new ForbiddenHttpException("403 Forbidden Error");
        }

        return $this->render('index', [
            'order' => $order,
            'items' => $order->orderProducts,
            'page' => $page,
        ]);
    }

}
