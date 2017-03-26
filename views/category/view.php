<?php
/* @var $this yii\web\View */
/* @var $page \app\models\Category */
/* @var $categories \app\models\Category[] */
/* @var $products \app\models\Product[] */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use app\helpers\ImageHelper;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;

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

    <?php Pjax::begin(['id' => 'pjax']); ?>

        <?= $this->render('_search', ['model' => $searchModel, 'page' => $page]); ?>

        <div class="row">
            <?php foreach ($categories as $category) : ?>
                <div class="col-sm-6 col-md-4">
                    <div class="card block-link">
                        <div class="card-img">
                            <img src="<?= ImageHelper::thumb($category->image->id, 'cover') ?>" class="img-responsive" alt="<?= $category->name ?>">
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

        <?php
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item',
            'layout' => "<div class=\"row\">{items}</div>\n<div class=\"clear-pager\">{pager}</div>",
            'emptyTextOptions' => [
                'class' => 'alert alert-danger',
            ],
        ]);
        ?>

    <?php Pjax::end(); ?>
</div>