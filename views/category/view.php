<?php
/* @var $this yii\web\View */
/* @var $page dench\products\models\Category */
/* @var $categories dench\products\models\Category[] */
/* @var $products dench\products\models\Product[] */
/* @var $searchModel dench\products\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $features dench\products\models\Feature[] */

use dench\image\helpers\ImageHelper;
use yii\bootstrap\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Products'),
    'url' => ['category/index'],
];
$this->params['breadcrumbs'][] = $page->name;
?>
<div class="container page">
    <h1 class="page-title"><?= $page->h1 ?></h1>
    <div class="page-text">
        <?= $page->text ?>
    </div>

    <?php Pjax::begin(['id' => 'pjax']); ?>

        <?= $this->render('_search', [
            'model' => $searchModel,
            'page' => $page,
            'features' => $features])
        ?>

        <div class="row">
            <?php foreach ($categories as $category) : ?>
                <div class="col-xs-6 col-sm-6 col-md-4">
                    <div class="card block-link">
                        <div class="card-img">
                            <img src="<?= ImageHelper::thumb($category->image->id, 'category') ?>" class="img-responsive" alt="<?= $category->image->alt ? $category->image->alt : $category->name ?>" title="<?= $category->title ?>">
                        </div>
                        <div class="card-block">
                            <div class="card-title h5">
                                <a href="<?= Url::to(['category/view', 'slug' => $category->slug]) ?>" class="text-nowrap"><?= $category->name ?></a>
                            </div>
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
            'itemOptions' => [
                'tag' => null,
            ],
        ]);
        ?>

    <?php Pjax::end(); ?>

    <div class="page-seo">
        <?= $page->seo ?>
    </div>
</div>

<?php

$script = <<< JS
$('.modal-callback-open').mousedown(function(){
    $('#modal-callback').modal('show').find('#modal-callback-content').load($(this).attr('data-target'));
});
JS;
$this->registerJs($script);

Modal::begin([
    'id' => 'modal-callback',
    'header' => '<h3>' . Yii::t('app', 'Callback') . '</h3>',
]);
echo Html::tag('div', '', ['id' => 'modal-callback-content']);
Modal::end();

?>