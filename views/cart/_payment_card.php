<?php
/**
 * @var $this \yii\web\View
 */

$text = Yii::t('app', 'Continue');

$js = <<<JS
$('#submitButton').text('{$text}');
JS;

$this->registerJs($js);