<?php
/* @var $this yii\web\View */
/* @var $page dench\page\models\Page */
/* @var $items dench\products\models\Variant[] */
/* @var $cart array */

use himiklab\yii2\recaptcha\ReCaptcha;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

$this->params['breadcrumbs'][] = $page->name;
?>
<div class="container page">

    <h1 class="page-title"><?= $page->h1 ?></h1>

    <?php if (Yii::$app->session->hasFlash('orderSubmitted')): ?>

        <div class="alert alert-success">
            Заказ успешно отправлен. Скоро с вами свяжется наш сотрудник для уточнения информации.
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
                    <div class="panel-heading">Необходимая информация для заказа</div>
                    <div class="panel-body">
                        <?= $form->field($model, 'name')->textInput(['placeholder' => 'Фамилия Имя Отчество']) ?>

                        <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                            'mask' => '+38 (099) 999-99-99',
                        ]) ?>

                        <?= $form->field($model, 'email')->textInput() ?>

                        <?= $form->field($model, 'entity')->radioList([
                            0 => 'Частное лицо ',
                            1 => 'Организация',
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
                    <div class="panel-heading">Способ доставки</div>
                    <div class="panel-body">
                        Выберите подходящий способ доставки

                        Cамовывоз
                        Новая почта
                        Ночной экспресс
                        Интайм
                        Деливери
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Способ оплаты</div>
                    <div class="panel-body">
                        Выберите способ оплаты заказа.

                        Наложеный платеж
                        Оплата при доставке
                        Банковский перевод (для юрлиц)
                        Карта Visa и MasterCard (LiqPay)
                        Мгновенная рассрочка (ПриватБанк)
                        Оплата частями (ПриватБанк)
                    </div>
                </div>
            </div>
        </div>


            <div class="text-muted">
                <b style="color: red;">*</b> - поля являются обязательными для заполнения
            </div>

            <div class="text-center mt-4">
                <?= Html::submitButton('Заказать', ['class' => 'btn btn-primary btn-lg']) ?>
            </div>

            <?php ActiveForm::end() ?>

        <?php endif; ?>

    <?php endif; ?>
</div>
