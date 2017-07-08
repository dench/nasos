<?php
/** @var $categories app\models\Category[] */

use dench\image\helpers\ImageHelper;
use yii\helpers\Url;

?>

<div class="row">
    <?php foreach ($categories as $category) : ?>
        <div class="col-xs-6 col-sm-6 col-md-4">
            <div class="card block-link">
                <div class="card-img">
                    <?php if ($category->image) { ?>
                        <img src="<?= ImageHelper::thumb($category->image->id, 'category') ?>" class="img-responsive" alt="<?= $category->image->alt ? $category->image->alt : $category->name ?>" title="<?= $category->title ?>">
                    <?php } else { ?>
                        <img src="<?= Yii::$app->params['image']['none'] ?>" class="img-responsive" alt="">
                    <?php } ?>
                </div>
                <div class="card-block">
                    <h5 class="card-title">
                        <a href="<?= Url::to(['category/view', 'slug' => $category->slug]) ?>" class="text-nowrap"><?= $category->name ?></a>
                    </h5>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>