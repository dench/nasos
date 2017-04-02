<?php

use app\models\Feature;
use dench\sortable\grid\SortableColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\admin\models\ValueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Values');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="value-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Value'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    if (Yii::$app->request->get('all')) {
        $all = Html::a(Yii::t('app', 'Show pagination'), Url::current(['all' => 0]));
    } else {
        $all = Html::a(Yii::t('app', 'Show all'), Url::current(['all' => 1]));
    }
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{summary}\n{$all}\n{items}\n{pager}",
        'rowOptions' => function ($model, $key, $index, $grid) {
            return [
                'data-position' => $model->position,
            ];
        },
        'columns' => [
            [
                'class' => SortableColumn::className(),
            ],
            [
                'attribute' => 'feature_id',
                'filter' => Feature::getList(null, null),
                'value' => 'feature.name',
            ],
            'name',
            'feature.after',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'options' => [
            'data' => [
                'sortable' => 1,
                'sortable-url' => Url::to(['sorting']),
            ]
        ],
    ]); ?>
</div>
