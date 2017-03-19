<?php

use app\models\Feature;
use dench\language\models\Language;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Value */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="value-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'feature_id')->dropDownList(Feature::getList(true, []), ['prompt' => '']) ?>

    <?php foreach (Language::suffixList() as $suffix => $name) : ?>
        <?= $form->field($model, 'name' . $suffix)->textInput(['maxlength' => true]) ?>
    <?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
