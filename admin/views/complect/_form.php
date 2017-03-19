<?php

use app\models\Product;
use dench\language\models\Language;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Complect */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="complect-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php foreach (Language::suffixList() as $suffix => $name) : ?>
        <?= $form->field($model, 'name' . $suffix)->textInput(['maxlength' => true]) ?>
    <?php endforeach; ?>

    <?= $form->field($model, 'product_id')->dropDownList(Product::getList(null)) ?>

    <?= $form->field($model, 'position')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
