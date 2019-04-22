<?php

namespace app\controllers;

use dench\page\models\Page;
use dench\cart\models\Order;
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
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex($id, $hash)
    {
        $page = Page::viewPage('order');

        if (!$order = Order::findOne($id)) {
            return false;
        }

        if ($hash !== md5($id . Yii::$app->params['order_secret'])) {
            throw new ForbiddenHttpException("403 Forbidden Error");
        }

        return $this->render('index', [
            'order' => $order,
            'items' => $order->orderProducts,
            'page' => $page,
        ]);
    }

}
