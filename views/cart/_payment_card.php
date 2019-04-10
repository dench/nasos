<?php
/**
 * @var $this \yii\web\View
 */

$text = Yii::t('app', 'To pay');

$js = <<<JS
$('#submitButton').text('{$text}');
JS;

$this->registerJs($js);