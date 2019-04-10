<?php
/**
 * @var $this \yii\web\View
 * @var $model \dench\cart\models\Payment
 */

use dench\cart\models\Payment;

echo $model->text;

if ($model->type === Payment::TYPE_CARD) {
    echo $this->render('_payment_card');
} else {
    $text = Yii::t('app', 'To order');
    $js = <<<JS
$('#submitButton').text('{$text}');
JS;
    $this->registerJs($js);
}