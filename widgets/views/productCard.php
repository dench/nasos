<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 25.03.17
 * Time: 13:30
 *
 * @var $model \dench\products\models\Product
 * @var $link string
 */
use dench\image\helpers\ImageHelper;

$variant = @$model->variants[0];
?>

<div class="col-xs-6 col-sm-4 col-md-3">
    <div class="card block-link">
        <?php if (in_array(2, $model->status_ids)) : ?>
            <i class="status status-2"></i>
        <?php endif; ?>
        <div class="card-img">
            <?php if ($model->image) { ?>
                <img src="<?= ImageHelper::thumb($model->image->id, 'small') ?>" class="img-responsive" alt="<?= $model->image->alt ? $model->image->alt : $model->name ?>" title="<?= $model->title ?>">
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
                <?php if ($model->price_from) : ?>
                    <?= Yii::t('app', 'from') ?>
                <?php endif; ?>
                <?= @$variant->currency->before ?>
                <?= @$variant->price ?>
                <?= @$variant->currency->after ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
