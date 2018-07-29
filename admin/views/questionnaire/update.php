<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Questionnaire */

$this->title = Yii::t('questionnaire', 'Update Questionnaire: ' . $model->name, [
    'nameAttribute' => '' . $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('questionnaire', 'Questionnaires'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('questionnaire', 'Update');
?>
<div class="questionnaire-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
