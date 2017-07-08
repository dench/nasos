<?php

use dench\image\helpers\ImageHelper;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $page dench\page\models\Page */
/* @var $categories app\models\Category[] */
?>
<section class="section bg-grey">
    <div class="container">
        <div class="header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="header-slogan">
                        <div class="header-slogan-big">
                            <?= Yii::t('app', 'Ukrainian producer of fueling solutions') ?>
                        </div>
                        <div class="header-slogan-small">
                            <div class="text-nowrap"><?= Yii::t('app', 'Set the task - we will solve it!') ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="header-contact">
                        <div class="header-contact-phone"><?= Yii::$app->params['phone1'] ?></div>
                        <div class="header-contact-phone"><?= Yii::$app->params['phone2'] ?></div>
                        <div class="header-contact-phone"><?= Yii::$app->params['phone3'] ?></div>
                        <div class="header-contact-time"><?= Yii::t('app', 'Calls from 9:00 to 20:00 Mon-Fri') ?></div>
                        <button class="btn btn-primary modal-callback-open" data-target="<?= Url::to(['site/callback']) ?>"><?= Yii::t('app', 'Callback') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-company bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="section-company-title"><?= $page->h1 ?></h1>
                <div class="section-company-text">
                    <?= $page->text ?>
                </div>
                <div class="section-company-link">
                    <a href="<?= Url::to(['site/about']) ?>" class="btn btn-secondary btn-lg"><?= Yii::t('app', 'Read more') ?></a>
                </div>
            </div>
            <div class="col-md-6 section-company-img">
                <a href="<?= Url::to(['site/about']) ?>" rel="nofollow"><img src="<?= ImageHelper::thumb(current($page->image_ids), 'page') ?>"  alt="<?= $page->title ?>" title="<?= $page->title ?>" class="img-responsive"></a>
            </div>
        </div>
    </div>
</section>

<section class="section section-category bg-grey">
    <div class="container">
        <h2 class="section-title"><a href="<?= Url::to(['/category/index']) ?>"><?= Yii::t('app', 'Our production') ?></a></h2>
        <?= Yii::$app->cache->getOrSet('_categories-' . Yii::$app->language, function () use ($categories) {
            return $this->render('../category/_categories', [
                'categories' => $categories,
            ]);
        });
        ?>
    </div>
</section>
<?php

$script = <<< JS
$('.modal-callback-open').on('click', function(e){
    e.preventDefault();
    $('#modal-callback').modal('show').find('#modal-callback-content').load($(this).attr('data-target'));
});
JS;
Yii::$app->view->registerJs($script);

Modal::begin([
    'id' => 'modal-callback',
    'header' => '<h3>' . Yii::t('app', 'Callback') . '</h3>',
]);
echo Html::tag('div', '', ['id' => 'modal-callback-content']);
Modal::end();

/*
?>
<section class="section section-news bg-white">
    <div class="container">
        <h2 class="section-title"><a href="#"><?= Yii::t('app', 'Company\'s news') ?></a></h2>
        <div class="row news">
            <div class="col-md-6">
                <div class="row news-item">
                    <div class="col-xs-4 col-sm-3 col-md-5 col-lg-4 news-item-img">
                        <img src="/img/photo-default.png" class="img-responsive img-thumbnail" alt="">
                    </div>
                    <div class="col-xs-8 col-sm-9 col-md-7 col-lg-8">
                        <h4 class="news-item-title"><a href="#">PA2 - Лопастной насос</a></h4>
                        <div class="news-item-text">
                            Насос имеет встроенный фильтр грубой очистки и обводной клапан, который «обводит» обводной клапан.
                            <div class="news-item-btn">
                                <a href="#" rel="nofollow" class="btn btn-default"><?= Yii::t('app', 'Read more') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row news-item">
                    <div class="col-xs-4 col-sm-3 col-md-5 col-lg-4 news-item-img">
                        <img src="/img/photo-default.png" class="img-responsive img-thumbnail" alt="">
                    </div>
                    <div class="col-xs-8 col-sm-9 col-md-7 col-lg-8">
                        <h4 class="news-item-title"><a href="#">PA2 - Лопастной насос</a></h4>
                        <div class="news-item-text">
                            Насос имеет встроенный фильтр грубой очистки и обводной клапан, который «обводит» обводной клапан.
                            <div class="news-item-btn">
                                <a href="#" rel="nofollow" class="btn btn-default"><?= Yii::t('app', 'Read more') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
*/