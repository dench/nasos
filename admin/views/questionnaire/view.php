<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Questionnaire;
use app\models\QuestionnaireForm;

/* @var $this yii\web\View */
/* @var $model app\models\Questionnaire */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('questionnaire', 'Questionnaires'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questionnaire-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('questionnaire', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('questionnaire', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('questionnaire', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'phone',
            [
                'attribute' => 'type',
                'value' => function(Questionnaire $model){
                    return QuestionnaireForm::typeList()[$model->type];
                },
            ],
            [
                'attribute' => 'section',
                'value' => function(Questionnaire $model){
                    return QuestionnaireForm::sectionList()[$model->section];
                },
            ],
            [
                'attribute' => 'fuel',
                'value' => function(Questionnaire $model){
                    return QuestionnaireForm::fuelList()[$model->fuel];
                },
            ],
            [
                'attribute' => 'performance',
                'value' => function(Questionnaire $model){
                    $performanceList = QuestionnaireForm::performanceList();
                    $value = [];
                    foreach ($model->performance as $performance) {
                        $value[] = $performanceList[$performance];
                    }
                    return implode(', ', $value);
                },
            ],
            [
                'attribute' => 'supply',
                'value' => function(Questionnaire $model){
                    $supplyList = QuestionnaireForm::supplyList();
                    $value = [];
                    foreach ($model->supply as $supply) {
                        $value[] = $supplyList[$supply];
                    }
                    return implode(', ', $value);
                },
            ],
            [
                'attribute' => 'level',
                'value' => function(Questionnaire $model){
                    return QuestionnaireForm::levelList()[$model->level];
                },
            ],
            [
                'attribute' => 'status',
                'value' => function(Questionnaire $model){
                    return Questionnaire::statusList()[$model->status];
                },
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
