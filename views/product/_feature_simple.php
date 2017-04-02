<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.04.17
 * Time: 23:09
 *
 * @var $model app\models\Product
 */
?>
<?php if ($model->variants[0]->values) : ?>
    <div class="table-responsive">
        <?= \app\widgets\FeaturesSimpleTable::widget([
            'variants' => $model->variants,
            'theadText' => Yii::t('app', 'Model'),
            'options' => [
                'class' => 'table table-striped table-hover table-condensed table-default table-head-bg',
            ],
        ]); ?>
    </div>
<?php endif; ?>

<div class="text-right">
    <span class="btn btn-link" onclick="window.print();"><i class="glyphicon glyphicon-print"></i> <?= Yii::t('app', 'Print version')?></span>
</div>