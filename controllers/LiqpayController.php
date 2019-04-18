<?php

namespace app\controllers;

use dench\cart\models\LiqpayLog;
use dench\cart\models\Order;
use Yii;
use yii\web\Controller;

class LiqpayController extends Controller
{
    public function actionIndex()
    {
        $data = Yii::$app->request->post('data');

        $signature = Yii::$app->request->post('signature');

        $private_key = Yii::$app->params['liqpay']['private_key'];

        $sign = base64_encode(sha1($private_key . $data . $private_key, 1));

        if ($signature !== $sign) die();

        $data = json_decode(base64_decode($data), true);

        LiqpayLog::add($data);

        $order_id = intval($data['order_id']);

        $order = Order::findOne($order_id);

        if (empty($order)) die();

        if ($order->status !== Order::STATUS_AWAITING) die();

        if ($data['status'] === 'success' || $data['status'] === 'sandbox') {
            $order->status = Order::STATUS_PAID;
            $order->update(false);
        } elseif ($data['status'] === 'error' || $data['status'] === 'failure') {
            $order->status = Order::STATUS_ERROR;
            $order->update(false);
        }

        die();
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}