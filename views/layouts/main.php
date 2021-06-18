<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\SiteAsset;
use dench\cart\widgets\OrderIconWidget;
use dench\cart\widgets\CartIconWidget;
use dench\modal\Modal;
use dench\products\models\Category;
use app\widgets\NavBar;
use dench\language\models\Language;
use dench\language\widgets\Lang;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;
use app\widgets\Breadcrumbs;

$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to((Yii::$app->language === 'uk' ? '/ua' : null) . explode('?', Yii::$app->request->url)[0], true)]);

$this->registerLinkTag(['rel' => 'alternate', 'hreflang' => 'ru-UA', 'href' => Url::current(['lang' => 'ru'], 'https')]);
$this->registerLinkTag(['rel' => 'alternate', 'hreflang' => 'uk-UA', 'href' => Url::current(['lang' => 'uk'], 'https')]);

SiteAsset::register($this);

$js = <<<JS
$('.block-link').click(function(){
    document.location.href = $(this).find('a').attr('href');
});
$('body').bind('copy', function() {
    return false;
});
JS;

$this->registerJs($js);
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
            'class' => 'navbar-nav navbar-right nav lang-change',
        ],
        'short' => true,
        'current' => Language::getCurrent(),
        'langs' => Language::nameList(),
    ]);
    $cart = CartIconWidget::widget();
    $order = OrderIconWidget::widget();
    NavBar::begin([
        'brandLabel' => '<img src="/img/benza.png" alt="Оборудование для АЗС">',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-static-top',
        ],
        'headerHtml' => $order . $cart . $lang,
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
                foreach (Category::getPodmenu() as $category) {
                    $items[] = [
                        'label' => $category['name'],
                        'url' => ['/category/view', 'slug' => $category['slug']],
                        'active' => (in_array($category['id'], $category_ids))
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
                    <?php
                        if (isset(Yii::$app->params['phone1'])) {
                            echo '<p><i class="glyphicon glyphicon-earphone">&ensp;</i>' . Yii::$app->params['phone1'] . '</p>';
                        }
                        if (isset(Yii::$app->params['phone2'])) {
                            echo '<p><i class="glyphicon glyphicon-earphone">&ensp;</i>' . Yii::$app->params['phone2'] . '</p>';
                        }
                        if (isset(Yii::$app->params['phone3'])) {
                            echo '<p><i class="glyphicon glyphicon-earphone">&ensp;</i>' . Yii::$app->params['phone3'] . '</p>';
                        }
                        if (isset(Yii::$app->params['phone4'])) {
                            echo '<p><i class="glyphicon glyphicon-earphone">&ensp;</i>' . Yii::$app->params['phone4'] . '</p>';
                        }
                    ?>
                </div>
            </div>
            <div class="col-sm-6 col-md-5">
                <div class="contacts">
                    <p><i class="glyphicon glyphicon-map-marker">&ensp;</i><a href="<?= Yii::$app->params['map_link'] ?>" target="_blank"><?= Yii::$app->params['address_' . Yii::$app->language] ?></a></p>
                    <p><i class="glyphicon glyphicon-time">&ensp;</i><?= Yii::t('app', 'Calls from 9:00 to 20:00 Mon-Fri') ?></p>
                </div>
            </div>
            <div class="col-sm-3 col-md-3">
                <?php
                $category_ids = isset($this->params['category_ids']) ? $this->params['category_ids'] : [];
                $items = null;
                $items[] = [
                    'label' => Yii::t('app', 'Products'),
                    'url' => ['/category/index'],
                ];
                foreach (Category::getPodmenu() as $category) {
                    $items[] = [
                        'label' => $category['name'],
                        'url' => ['/category/view', 'slug' => $category['slug']],
                        'active' => (in_array($category['id'], $category_ids))
                    ];
                }
                unset($items[count($items) - 1]);
                foreach ($items as $item) {
                    echo Html::tag('div', Html::a($item['label'], $item['url']));
                }
                ?>
            </div>
            <div class="col-sm-12 col-md-2">
                <div class="copyright">
                    <p>© <a href="/"><?= Yii::$app->params['sitename'] ?></a> 2017 - <?= date('Y') ?></p>
                </div>
            </div>
        </div>
    </div>
</footer>
<?= Modal::widget([
    'titleTag' => 'h3',
    'center' => true,
    'size' => 'modal-lg',
]); ?>
<?= $this->render('_counters') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
