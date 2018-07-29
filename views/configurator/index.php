<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
use app\models\QuestionnaireForm;
use himiklab\yii2\recaptcha\ReCaptcha;

/* @var $this yii\web\View */
/* @var $page dench\page\models\Page */

$this->params['breadcrumbs'][] = $page->name;
?>
<div class="container page">
    <h1 class="page-title"><?= $page->h1 ?></h1>
    <div class="page-text">

        <?php if (Yii::$app->session->hasFlash('questionnaireFormSubmitted')): ?>

            <div class="alert alert-success">
                <?= Yii::t('app', 'Thank you for contacting us. We will respond to you as soon as possible.') ?>
            </div>

        <?php else: ?>

            <?= $page->short ?>

            <?php $form = ActiveForm::begin(); ?>

            <div class="row">
                <div class="col-lg-5">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
                        'mask' => '+38 (099) 999-99-99',
                    ]) ?>
                </div>
            </div>

            <?= $form->field($model, 'type')->radioList(QuestionnaireForm::typeList()) ?>

            <?= $form->field($model, 'section')->inline()->radioList(QuestionnaireForm::sectionList()) ?>

            <?= $form->field($model, 'fuel')->inline()->radioList(QuestionnaireForm::fuelList()) ?>

            <?= $form->field($model, 'performance')->inline()->checkboxList(QuestionnaireForm::performanceList()) ?>

            <?= $form->field($model, 'supply')->checkboxList(QuestionnaireForm::supplyList()) ?>

            <?= $form->field($model, 'level')->radioList(QuestionnaireForm::levelList()) ?>

            <?= $form->field($model, 'reCaptcha')->widget(ReCaptcha::className()) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('questionnaire', 'Send'), ['class' => 'btn btn-success btn-lg']) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <?= $page->text ?>

        <?php endif; ?>
    </div>
</div>