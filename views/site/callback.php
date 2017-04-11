<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 11.04.17
 * Time: 21:39
 *
 * @var $this yii\web\View
 * @var $form yii\bootstrap\ActiveForm
 * @var $model app\models\ContactForm
 */
use himiklab\yii2\recaptcha\ReCaptcha;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$url = Url::to(['site/callback']);

$script = <<< JS
$('#{$model->formName()}').on('beforeSubmit', function(e){
    var form = $(this);
    $.ajax({
        url: form.attr("action"),
        type: "post",
        data: form.serialize(),
        success: function (response) {
            if (response == 'success') {
                $('#modal-callback-content').load('{$url}');
            }
        },
        error: function () {
            console.log("internal server error");
        }
    });
    return false;
});
JS;
Yii::$app->view->registerJs($script);

?>

<?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

    <div class="alert alert-success">
        <?= Yii::t('app', 'Thank you for contacting us. We will respond to you as soon as possible.') ?>
    </div>

<?php else: ?>

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'phone') ?>

    <?= $form->field($model, 'reCaptcha')->widget(ReCaptcha::className()) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'callback-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

<?php endif; ?>
