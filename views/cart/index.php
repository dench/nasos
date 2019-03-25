<?php
/* @var $this yii\web\View */
/* @var $page dench\page\models\Page */
/* @var $items dench\products\models\Variant[] */
/* @var $cart array */

use dench\cart\models\Delivery;
use dench\cart\models\Payment;
use himiklab\yii2\recaptcha\ReCaptcha;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\MaskedInput;

$this->params['breadcrumbs'][] = $page->name;

$delivery_url = Url::to('cart/delivery');
$payment_url = Url::to('cart/payment');

$js = <<<JS
$('#delivery_id').change(function(){
    var iD = $(this).find(':checked').val();
    $.get('{$delivery_url}', { id: iD }, function(data){
        $('#delivery-info').html(data.text);
    }, 'json');
});
$('#payment_id').change(function(){
    var iD = $(this).find(':checked').val();
    $.get('{$payment_url}', { id: iD }, function(data){
        $('#payment-info').html(data.text);
    }, 'json');
});
JS;

$this->registerJs($js);
?>
<div class="container page">

    <h1 class="page-title"><?= $page->h1 ?></h1>

    <?php if (Yii::$app->session->hasFlash('orderSubmitted')): ?>

        <div class="alert alert-success">
            <?= Yii::t('app', 'Order is accepted. Soon our employee will contact you to clarify information.') ?>
        </div>

    <?php else: ?>

        <?= $page->short ?>
        <?= $page->text ?>

        <?= $this->render('_table', [
            'items' => $items,
            'cart' => $cart,
        ]) ?>

        <?php if ($items) : ?>

            <?php $form = ActiveForm::begin() ?>

        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><?= Yii::t('app', 'Required information for ordering') ?></div>
                    <div class="panel-body">
                        <?= $form->field($model, 'name')->textInput(['placeholder' => Yii::t('app', 'Full name')]) ?>

                        <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                            'mask' => '+38 (099) 999-99-99',
                        ]) ?>

                        <?= $form->field($model, 'email')->textInput() ?>

                        <?= $form->field($model, 'entity')->radioList([
                            0 => Yii::t('app', 'Private person'),
                            1 => Yii::t('app', 'Organization'),
                        ], ['class' => 'pt-2']) ?>

                        <?php if (!YII_DEBUG): ?>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <?= $form->field($model, 'reCaptcha')->widget(ReCaptcha::class)->label(false) ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><?= Yii::t('app', 'Delivery method') ?></div>
                    <div class="panel-body">
                        <?= $form->field($model, 'delivery_id')->radioList(Delivery::getList(), [
                            'class' => 'pt-2',
                            'id' => 'delivery_id',
                            'item' => function ($index, $label, $name, $checked, $value) {
                                return '<div class="radio"><label>' . Html::radio($name, $checked, ['value' => $value]) . $label . '</label></div>';
                            },
                        ]) ?>
                        <div id="delivery-info"></div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading"><?= Yii::t('app', 'Payment method') ?></div>
                    <div class="panel-body">
                        <?= $form->field($model, 'payment_id')->radioList(Payment::getList(), ['class' => 'pt-2', 'id' => 'payment_id']) ?>
                        <div id="payment-info"></div>
                    </div>
                </div>
            </div>
        </div>


            <div class="text-muted">
                <b style="color: red;">*</b> <?= Yii::t('app', ' - fields are required') ?>
            </div>

            <div class="text-center mt-4">
                <?= Html::submitButton(Yii::t('app', 'To order'), ['class' => 'btn btn-primary btn-lg']) ?>
            </div>

            <?php ActiveForm::end() ?>

        <?php endif; ?>

    <?php endif; ?>
</div>
