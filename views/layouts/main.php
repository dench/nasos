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
use yii\widgets\Breadcrumbs;

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
        ],
        'headerHtml' => $lang,
    ]);
    echo Nav::widget([
        'options' => [
            'class' => 'navbar-nav',
        ],
        'items' => [
            ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index'], 'options' => ['class' => 'hidden-sm']],
            [
                'label' => Yii::t('app', 'Products'),
                'url' => ['/category/index'],
                'options' => [
                    'class' => 'pod',
                ],
                'active' => (Yii::$app->controller->id == 'product' || Yii::$app->controller->id == 'category')
            ],
            ['label' => Yii::t('app', 'About company'), 'url' => ['/site/about']],
            [
                'label' => Yii::t('app', 'Information'),
                'url' => ['/info/index'],
                'active' => Yii::$app->controller->id == 'info'],
            ['label' => Yii::t('app', 'Contacts'), 'url' => ['/site/contacts']],
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
            <div class="col-sm-3 col-md-2">
                <div class="contacts phones">
                    <p><i class="glyphicon glyphicon-earphone">&ensp;</i><?= Yii::$app->params['phone1'] ?></p>
                    <p><i class="glyphicon glyphicon-earphone">&ensp;</i><?= Yii::$app->params['phone2'] ?></p>
                </div>
            </div>
            <div class="col-sm-3 col-md-2">
                <div class="contacts phones">
                    <p><i class="glyphicon glyphicon-earphone">&ensp;</i><?= Yii::$app->params['phone3'] ?></p>
                    <p><i class="glyphicon glyphicon-earphone">&ensp;</i><?= Yii::$app->params['phone4'] ?></p>
                </div>
            </div>
            <div class="col-sm-6 col-md-5">
                <div class="contacts">
                    <p><i class="glyphicon glyphicon-map-marker">&ensp;</i><a href="<?= Yii::$app->params['map_link'] ?>" target="_blank"><?= Yii::$app->params['address_' . Yii::$app->language] ?></a></p>
                    <p><i class="glyphicon glyphicon-time">&ensp;</i><?= Yii::t('app', 'Calls from 9:00 to 20:00 Mon-Fri') ?></p>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="copyright">
                    <p>© <a href="/"><?= Yii::$app->params['sitename'] ?></a> 2017</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<?= $this->render('_counters') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
