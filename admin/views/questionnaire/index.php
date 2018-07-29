<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Questionnaire;
use app\models\QuestionnaireForm;

/* @var $this yii\web\View */
/* @var $searchModel app\admin\models\QuestionnaireSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('questionnaire', 'Questionnaires');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questionnaire-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('questionnaire', 'Create Questionnaire'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'phone',
            [
                'attribute' => 'type',
                'value' => function(Questionnaire $model){
                    return QuestionnaireForm::typeList()[$model->type];
                },
            ],
            //'section',
            //'fuel',
            //'performance',
            //'supply',
            //'level',
            [
                'attribute' => 'status',
                'filter' => Questionnaire::statusList(),
                'content' => function($model, $key, $index, $column){
                    $statusList = Questionnaire::statusList();
                    $class = 'default';
                    if ($model->status == Questionnaire::STATUS_NEW) {
                        $class = 'danger';
                    } else if ($model->status == Questionnaire::STATUS_READ) {
                        $class = 'success';
                    }
                    return '<span class="badge badge-' . $class . '">' . $statusList[$model->status] . '</span>';
                },
            ],
            'created_at:date',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
