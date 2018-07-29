<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\models\Questionnaire;
use app\models\QuestionnaireForm;

/* @var $this yii\web\View */
/* @var $model app\models\Questionnaire */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="questionnaire-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->radioList(QuestionnaireForm::typeList()) ?>

    <?= $form->field($model, 'section')->inline()->radioList(QuestionnaireForm::sectionList()) ?>

    <?= $form->field($model, 'fuel')->inline()->radioList(QuestionnaireForm::fuelList()) ?>

    <?= $form->field($model, 'performance')->inline()->checkboxList(QuestionnaireForm::performanceList()) ?>

    <?= $form->field($model, 'supply')->checkboxList(QuestionnaireForm::supplyList()) ?>

    <?= $form->field($model, 'level')->radioList(QuestionnaireForm::levelList()) ?>

    <?= $form->field($model, 'status')->dropDownList(Questionnaire::statusList()) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('questionnaire', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
