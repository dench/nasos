<?php

namespace app\controllers;

use app\widgets\CartIconWidget;
use dench\cart\models\Cart;
use dench\cart\models\OrderForm;
use dench\page\models\Page;
use dench\products\models\Variant;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;

/**
 * Class CartController
 * @package app\controllers
 */
class CartController extends Controller
{

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\AjaxFilter',
                'only' => ['modal', 'add', 'del'],
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        $page = Page::viewPage('cart');

        $cart = Cart::getCart();

        $variant_ids = array_keys($cart);

        $items = Variant::find()->where(['id' => $variant_ids])->andWhere(['enabled' => true])->all();

        $model = new OrderForm();

        $model->scenario = 'user';

        if ($model->load(Yii::$app->request->post()) && $model->send()) {
            Yii::$app->session->setFlash('orderSubmitted');
            return $this->redirect(['']);
        }

        return $this->render('index', [
            'page' => $page,
            'items' => $items,
            'cart' => $cart,
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionModal()
    {
        $footer = Html::button(Yii::t('app', 'Continue shopping'), ['class' => 'btn btn-primary mr-auto', 'data-dismiss' => 'modal']);
        $footer .= Html::a(Yii::t('app', 'Place an order'), ['/cart/index'], ['class' => 'btn btn-warning']);

        $cart = Cart::getCart();

        $variant_ids = array_keys($cart);

        $items = Variant::find()->where(['id' => $variant_ids])->andWhere(['enabled' => true])->all();

        $data = [
            'title' => Yii::t('app', 'Buy'),
            'body' => $this->renderAjax('modal', [
                'items' => $items,
                'cart' => $cart,
            ]),
            'footer' => $footer,
            'size' => 'modal-lg',
        ];

        return Json::encode($data);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionBlock()
    {
        return CartIconWidget::widget();
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionDel($id)
    {
        $cart = Cart::getCart();

        ArrayHelper::remove($cart, $id);

        return Cart::setCart($cart);
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionAdd($id)
    {
        $cart = Cart::getCart();

        ArrayHelper::setValue($cart, $id, ArrayHelper::getValue($cart, $id) + 1);

        return Cart::setCart($cart);
    }

    /**
     * @param $id
     * @param $count
     * @return bool
     */
    public function actionSet($id, $count)
    {
        $cart = Cart::getCart();

        $cart[$id] = $count;

        return Cart::setCart($cart);
    }
}
