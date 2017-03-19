<?php
/** @var $this yii\web\View */
use app\helpers\ImageHelper;
use yii\helpers\Url;

/** @var $page \app\models\Category */
/** @var $categories \app\models\Category[] */
/** @var $products \app\models\Product[] */

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Products'),
    'url' => ['category/index'],
];
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
                        <img src="<?= ImageHelper::normal($category->image->id) ?>" class="img-responsive" alt="<?= $category->name ?>">
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

    <div class="row">
        <?php foreach ($products as $product) : ?>
            <div class="col-sm-4 col-md-3">
                <div class="card block-link">
                    <div class="card-img">

                        <img src="<?= ImageHelper::normal($product->variants[0]->images[0]->id) ?>" class="img-responsive" alt="<?= $product->name ?>">
                    </div>
                    <div class="card-block">
                        <h5 class="card-title">
                            <a href="<?= Url::to(['product/index', 'slug' => $product->slug]) ?>"><?= $product->name ?></a>
                        </h5>
                        <?php
                        $count = count($product->variants);
                        if ($count > 0) {
                            echo '<div class="card-price">';
                            if ($count > 1) {
                                echo Yii::t('app', 'from') . ' ';
                            }
                            echo $product->variants[0]->price;
                            echo ' ' . Yii::t('app', 'UAH');
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php endforeach;  ?>
    </div>
</div>
