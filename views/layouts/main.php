<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\SiteAsset;
use app\models\Category;
use app\widgets\NavBar;
use dench\language\models\Language;
use dench\language\widgets\Lang;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use app\assets\CommonAsset;
use yii\widgets\Breadcrumbs;

CommonAsset::register($this);
SiteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    $lang = Lang::widget([
        'options' => [
            'class' => 'navbar-right nav lang-change',
        ],
        'short' => true,
        'current' => Language::getCurrent(),
        'langs' => Language::nameList(),
    ]);
    NavBar::begin([
        'brandLabel' => '<img src="/img/benza.png" alt="Бенза">',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-static-top',
            'title' => 'Бенза',
        ],
        'headerHtml' => $lang,
    ]);
    echo Nav::widget([
        'options' => [
            'class' => 'navbar-nav',
        ],
        'items' => [
            ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
            [
                'label' => Yii::t('app', 'Products'),
                'url' => ['/category/index'],
                'options' => [
                    'class' => 'pod',
                ],
                'active' => (Yii::$app->controller->id == 'product' || Yii::$app->controller->id == 'category')
            ],
            ['label' => Yii::t('app', 'About company'), 'url' => ['/site/about']],
            //['label' => Yii::t('app', 'Gallery'), 'url' => ['/gallery/index']],
            //['label' => Yii::t('app', 'Documentation'), 'url' => '/docs/index', 'options' => ['class' => 'hidden-sm']],
            ['label' => Yii::t('app', 'Contacts'), 'url' => ['/site/contact']],
        ],
    ]);
    NavBar::end();
    ?>

    <?php if (Yii::$app->controller->id == 'product' || Yii::$app->controller->id == 'category') : ?>
        <div class="podmenu">
            <div class="container">
                <?php
                $category_ids = isset($this->params['category_ids']) ? $this->params['category_ids'] : [];
                $items = [];
                foreach (Category::getMain() as $category) {
                    $items[] = [
                        'label' => $category->name,
                        'url' => ['/category/view', 'slug' => $category->slug],
                        'active' => (in_array($category->id, $category_ids))
                    ];
                }
                echo Nav::widget([
                    'options' => [
                        'class' => 'nav-pills',
                    ],
                    'items' => $items,
                ]);
                ?>
            </div>
        </div>
    <?php endif; ?>

    <?php
    if (isset($this->params['breadcrumbs'])) {
        echo Html::tag(
            'div',
            Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'],
                'homeLink' => [
                    'label' => 'Бенза',
                    'url' => Yii::$app->homeUrl,
                ],
                'options' => [
                    'class' => 'breadcrumb container',
                ]
            ]), [
            'class' => 'bg-grey'
        ]);
    }
    ?>

    <?= $content ?>
</div>
<footer class="footer footer-inverse bg-inverse">
    <div class="container">
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4 text-center">
                <div class="copyright">
                    <img src="/img/benza-transparent.png" alt="Бенза" class="img-responsive">
                    © <a href="#">БЕНЗА</a> 2017
                </div>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
