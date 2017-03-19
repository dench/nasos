<?php
use app\helpers\ImageHelper;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $model app\models\Product */

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Products'),
    'url' => ['category/index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $model->categories[0]->name,
    'url' => ['category/view', 'slug' => $model->categories[0]->slug],
];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container page product">
    <h1 class="page-title"><?= $model->h1 ?></h1>
    <div class="row">
        <div class="col-md-5">
            <?php
            $image = @$model->variants[0]->images[0];
            ?>
            <div class="product-photo">
                <?php if ($image) { ?>
                <a href="<?= ImageHelper::big($image->id) ?>" class="thumbnail">
                    <img src="<?= ImageHelper::cover($image->id) ?>" alt="<?= $model->name ?>">
                </a>
                <?php } else { ?>
                    <div class="thumbnail">
                        <img src="/img/photo-default.png" alt="photo-default">
                    </div>
                <?php } ?>
            </div>
            <?php
            $images = [];
            foreach ($model->variants as $variant) {
                foreach ($variant->images as $image) {
                    $images[] = $image;
                }
            }
            if (count($images) > 1) {
                $js = <<<JS
$('.product-photos a').click(function(e){
    $('.product-photos a').removeClass('active');
    var photo = $('.product-photo');
    var small = $(this).find('img').attr('src');
    photo.find('img').attr('src', small.replace('small','cover'));
    $(this).addClass('active');
    e.preventDefault();
});
JS;
                $this->registerJs($js);
            }
            ?>
            <?php if (count($images) > 1) : ?>
            <div class="row product-photos">
                <?php foreach ($images as $image) : ?>
                    <div class="col-xs-4 col-sm-3 col-md-4">
                        <a href="<?= ImageHelper::big($image->id) ?>" class="thumbnail<?php if ($model->variants[0]->images[0]->id == $image->id) echo " active"; ?>">
                            <img src="<?= ImageHelper::small($image->id) ?>" alt="<?= $model->name ?>">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <?php if ($model->variants[0]->values) : ?>
            <table class="table table-striped table-hover table-condensed table-default">
                <thead>
                <tr>
                    <th><?= Yii::t('app', 'Model') ?></th>
                    <th><?= Yii::t('app', 'Price, UAH') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($model->variants as $variant) : ?>
                    <tr>
                        <th><?= $variant->name ?></th>
                        <td><?= $variant->price ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
        <div class="col-md-7">
            <?php if ($model->variants[0]->values) : ?>
                <div class="table-responsive">
                    <?= \app\widgets\FeaturesTable::widget([
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
        </div>
    </div>
    <div class="product-section">
        <h2 class="product-section-title"><span class="line"><?= $model->name ?></span></h2>
        <?= $model->text ?>
    </div>
    <?php if ($model->complects) : ?>
    <div class="product-section">
        <h2 class="product-section-title"><span class="line"><?= Yii::t('app', 'Complectation') ?></span></h2>
        <ul>
            <?php foreach ($model->complects as $complect) : ?>
                <li><?= $complect->name ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    <?php if ($model->options) : ?>
    <div class="product-section">
        <h2 class="product-section-title"><span class="line"><?= Yii::t('app', 'Additional options') ?></span></h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-condensed table-default table-width-auto">
                <thead>
                <tr>
                    <th></th>
                    <th><?= Yii::t('app', 'Price, UAH') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($model->options as $option) : ?>
                    <tr>
                        <th><a href="<?= Url::to(['product/index', 'slug' => $option->slug]) ?>" target="_blank"><?= $option->name ?></a></th>
                        <td><?= $option->variants[0]->price ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>

<section class="section section-category bg-grey">
    <div class="container">
        <h3><?= Yii::t('app', 'You looked through') ?></h3>
        <div class="row">
            <div class="col-xs-6 col-sm-4 col-md-3">
                <div class="card">
                    <div class="card-img">
                        <img src="/img/category.jpg" class="img-responsive" alt="">
                    </div>
                    <div class="card-block">
                        <h5 class="card-title">
                            <a href="#" class="text-nowrap">Насосы</a>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3">
                <div class="card">
                    <div class="card-img">
                        <img src="/img/category.jpg" class="img-responsive" alt="">
                    </div>
                    <div class="card-block">
                        <h5 class="card-title">
                            <a href="#" class="text-nowrap">Насосы</a>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3">
                <div class="card">
                    <div class="card-img">
                        <img src="/img/category.jpg" class="img-responsive" alt="">
                    </div>
                    <div class="card-block">
                        <h5 class="card-title">
                            <a href="#" class="text-nowrap">Насосы</a>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3">
                <div class="card">
                    <div class="card-img">
                        <img src="/img/category.jpg" class="img-responsive" alt="">
                    </div>
                    <div class="card-block">
                        <h5 class="card-title">
                            <a href="#" class="text-nowrap">Насосы</a>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>