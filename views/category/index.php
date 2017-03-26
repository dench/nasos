<?php
use app\helpers\ImageHelper;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $page \app\models\Page */
/** @var $categories \app\models\Category[] */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container page">

    <h1 class="page-title"><?= $page->h1 ?></h1>

    <div class="page-text">
        <?= $page->text ?>
    </div>

    <div class="row">
        <?php foreach ($categories as $category) : ?>
            <div class="col-sm-6 col-md-4">
                <div class="card block-link">
                    <div class="card-img">
                        <?php if ($category->image) { ?>
                            <img src="<?= ImageHelper::thumb($category->image->id, 'cover') ?>" class="img-responsive" alt="<?= $category->name ?>">
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
</div>
