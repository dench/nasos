<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 25.03.17
 * Time: 13:30
 *
 * @var $model dench\products\models\Product
 * @var $link string
 * @var $this yii\web\View
 */

use app\widgets\FeaturesTable;
use dench\image\helpers\ImageHelper;
use yii\helpers\Url;
use yii\web\View;

$variant = @$model->variants[0];

$url_add = Url::to(['/cart/add']);
$url_modal = Url::to(['/cart/modal']);

$js = <<<JS
$('.btn-buy').mousedown(function(){
    var id = $(this).attr('rel');
    $.get('{$url_add}', { id: id }, function(){
        openModal('{$url_modal}');
    });
});
JS;

$this->registerJs($js, View::POS_READY, 'btn-buy');
?>

<div class="col-xs-6 col-sm-4 col-md-3">
    <div class="card block-link">
        <?php if (in_array(2, $model->status_ids)) : ?>
            <i class="status status-2"></i>
        <?php endif; ?>
        <div class="card-img">
            <?php if ($model->image) { ?>
                <img src="<?= ImageHelper::thumb($model->image->id, 'small') ?>" class="img-responsive" alt="<?= $model->name ?>" title="<?= $model->name ?>">
            <?php } else { ?>
                <img src="<?= Yii::$app->params['image']['none'] ?>" class="img-responsive" alt="">
            <?php } ?>
        </div>
        <div class="card-block">
            <div class="card-title h5">
                <a href="<?= $link ?>"><?= $model->name ?></a>
            </div>
            <?php if (@$variant->price) : ?>
            <div class="card-price">
                <b><?= Yii::t('app', 'Price') ?></b>
                <?php if ($model->price_from) : ?>
                    <?= Yii::t('app', 'from') ?>
                <?php endif; ?>
                <?= @$variant->currency->before ?>
                <?= @$variant->price ?>
                <?= @$variant->currency->after ?>
            </div>
            <?= FeaturesTable::widget([
                'variants' => $model->variants,
                'limit' => 3,
                'options' => [
                    'class' => 'card-features',
                ],
            ]); ?>
            <button class="btn btn-primary btn-block btn-buy btn-lg" rel="<?= $model->variants[0]->id ?>"><?= Yii::t('app', 'Buy') ?></button>
            <?php endif; ?>
        </div>
    </div>
</div>
