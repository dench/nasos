<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */
/* @var $page dench\page\models\Page */

use himiklab\yii2\recaptcha\ReCaptcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container page">

    <h1 class="page-title"><?= $page->h1 ?></h1>

    <div class="page-text">
        <?= $page->text ?>
    </div>

    <div class="page-title"><?= Yii::t('app', 'Feedback') ?></div>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            <?= Yii::t('app', 'Thank you for contacting us. We will respond to you as soon as possible.') ?>
        </div>

    <?php else: ?>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'reCaptcha')->widget(ReCaptcha::className()) ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>
