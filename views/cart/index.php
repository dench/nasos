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
                    <div class="panel-heading">Дополнительная информация о себе</div>
                    <div class="panel-body">
                        <div class="alert alert-warning">
                            Если хотите, можете указать дополнительную информацию о себе.
                            Это позволит нашим сотрудникам быстрее подготовить и отправить
                            Вам счет на оплату заказанной продукции.
                        </div>

                        <?= $form->field($model, 'delivery')->widget(MaskedInput::className(), [
                            'mask' => 'город *{3,20}, отделение новой почты № 9{1,4}',
                        ])->textInput(['placeholder' => 'Введите город и номер отделения Новой почты']) ?>

                        <?= $form->field($model, 'email')->textInput() ?>

                        <?= $form->field($model, 'entity')->radioList([
                            0 => 'Частное лицо ',
                            1 => 'Организация',
                        ], ['class' => 'pt-2']) ?>

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
