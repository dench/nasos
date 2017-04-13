<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 25.03.17
 * Time: 13:30
 *
 * @var $model \app\models\Product
 * @var $link string
 */
use dench\image\helpers\ImageHelper;

$variant = @$model->variants[0];
?>

<div class="col-sm-4 col-md-3">
    <div class="card block-link">
        <div class="card-img">
            <?php if ($model->image) { ?>
                <img src="<?= ImageHelper::thumb($model->image->id, 'cover') ?>" class="img-responsive" alt="<?= $model->image->alt ? $model->image->alt : $model->name ?>" title="<?= $model->title ?>">
            <?php } else { ?>
                <img src="<?= Yii::$app->params['image']['none'] ?>" class="img-responsive" alt="">
            <?php } ?>
        </div>
        <div class="card-block">
            <h5 class="card-title">
                <a href="<?= $link ?>"><?= $model->name ?></a>
            </h5>
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
