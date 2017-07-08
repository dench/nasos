<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 05.07.17
 * Time: 20:21
 *
 * @var $this yii\web\View
 * @var $model dench\page\models\Page
 */
use dench\image\helpers\ImageHelper;
use yii\helpers\Url;

?>
<div class="col-md-6">
    <div class="row news-item">
        <div class="col-xxs-4 col-xs-3 col-sm-3 col-md-5 col-lg-4 news-item-img">
            <a href="<?= Url::to(['view', 'slug' => $model->slug]) ?>" rel="nofollow">
                <?php if ($model->image) : ?>
                    <img src="<?= ImageHelper::thumb($model->image->id, 'small') ?>" alt="<?= $model->image->alt ?>" class="img-responsive img-thumbnail">
                <?php else : ?>
                    <img src="<?= Yii::$app->params['image']['none'] ?>" class="img-responsive img-thumbnail img-none">
                <?php endif; ?>
            </a>
        </div>
        <div class="col-xxs-8 col-xs-9 col-sm-9 col-md-7 col-lg-8">
            <h4 class="news-item-title"><a href="<?= Url::to(['view', 'slug' => $model->slug]) ?>"><?= $model->name ?></a></h4>
            <div class="news-item-text">
                <?= $model->description ?>
            </div>
        </div>
    </div>
</div>