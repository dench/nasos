<?php
/**
 * @var $this yii\web\View
 * @var $order \dench\cart\models\Order
 * @var $items \dench\cart\models\OrderProduct[]
 * @var $page \dench\page\models\Page
 */

use dench\cart\models\Order;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = Yii::t('app', 'Order #{order_id}', ['order_id' => $order->id]);

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container page">

    <h1 class="page-title"><?= $this->title ?></h1>

    <?php
    $statusList = Order::statusList();
    echo '<div class="alert alert-info">' . Yii::t('app', 'Current order status') . ': <b>' . $statusList[$order->status] . '</b></div>';
    ?>

    <?= $page->short ?>

    <div class="table-responsive">
        <table class="table table-sm table-bordered bg-white text-center align-middle table-cart">
            <tbody>
            <tr class="active">
                <th>№</th>
                <th><?= Yii::t('app', 'Product name') ?></th>
                <th><?= Yii::t('app', 'Count') ?></th>
                <th><?= Yii::t('app', 'Price per unit') . ', ' . $items[0]->variant->currency->before . $items[0]->variant->currency->after ?></th>
                <th><?= Yii::t('app', 'Amount') . ', ' . $items[0]->variant->currency->before . $items[0]->variant->currency->after ?></th>
            </tr>
            <?php foreach ($items as $k => $item) : ?>
                <tr>
                    <td><?= $k + 1 ?></td>
                    <td class="text-left">
                        <?= Html::a($item->name, ['product/index', 'slug' => $item->variant->product->slug]) ?>
                    </td>
                    <td>
                        <?= $item->count ?>
                    </td>
                    <td>
                        <?= $item->price ?>
                    </td>
                    <td>
                        <?= $item->count * $item->price ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-right" style="margin-bottom: 30px;">
        <?= Yii::t('app', 'Total amount') ?>: <span class="total h4"><?= $order->amount ?></span> <?= $items[0]->variant->currency->before . $items[0]->variant->currency->after ?>
    </div>

    <?= DetailView::widget([
        'model' => $order,
        'attributes' => [
            [
                'label' => Yii::t('app', 'Payment method'),
                'value' => $order->payment_id ? $order->paymentMethod->name : null,
            ],
            [
                'label' => Yii::t('app', 'Delivery method'),
                'value' => $order->delivery_id ? $order->deliveryMethod->name : null,
            ],
            'delivery',
            'created_at:datetime',
            [
                'label' => Yii::t('app', 'Order\'s full name'),
                'value' => $order->buyer->name,
            ],
            'phone',
            'email',
        ],
    ]); ?>

    <?= $page->text ?>
</div>
