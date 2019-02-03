<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 07.03.17
 * Time: 20:25
 */

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AdminAsset;
use app\widgets\Alert;
use dench\cart\models\Order;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AdminAsset::register($this);
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
    NavBar::begin([
        'brandLabel' => Yii::t('app', 'Admin'),
        'brandUrl' => ['default/index'],
        'options' => [
            'class' => 'navbar-inverse navbar-static-top',
        ],
    ]);

    if ($unread = \app\models\Questionnaire::unread()) {
        $unread_question = ' <span class="badge badge-danger">' . $unread . '</span>';
    } else {
        $unread_question = '';
    }

    if ($unread = Order::unread()) {
        $unread_order = ' <span class="badge badge-danger">' . $unread . '</span>';
    } else {
        $unread_order = '';
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => [
            ['label' => Yii::t('app', 'Categories'), 'url' => ['/admin/products/category/index']],
            ['label' => Yii::t('app', 'Products'), 'url' => ['/admin/products/default/index']],
            ['label' => Yii::t('app', 'Features'), 'url' => ['/admin/products/feature/index']],
            ['label' => Yii::t('app', 'Complectation'), 'url' => ['/admin/products/complect/index']],
            ['label' => Yii::t('app', 'Pages'), 'url' => ['/admin/page/default/index']],
            ['label' => Yii::t('questionnaire', 'Questionnaire') . $unread_question, 'url' => ['/admin/questionnaire/index']],
            ['label' => Yii::t('app', 'Orders') . $unread_order, 'url' => ['/admin/cart/order/index']],
            ['label' => Yii::t('app', 'Other'), 'url' => '#', 'items' => [
                ['label' => Yii::t('app', 'Blocks'), 'url' => ['/admin/block/default/index']],
                ['label' => Yii::t('app', 'Brands'), 'url' => ['/admin/products/brand/index']],
                ['label' => Yii::t('app', 'Currencies'), 'url' => ['/admin/products/currency/index']],
                ['label' => Yii::t('app', 'Units'), 'url' => ['/admin/products/unit/index']],
                ['label' => Yii::t('app', 'Statuses'), 'url' => ['/admin/products/product-status/index']],
                ['label' => Yii::t('app', 'Users'), 'url' => ['/admin/user/index']],
                ['label' => Yii::t('app', 'Buyers'), 'url' => ['/admin/cart/buyer/index']],
                ['label' => Yii::t('app', 'Settings'), 'url' => ['/admin/setting/index']],
            ]],
            ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => Yii::t('app', 'Admin'), 'url' => '/admin/default/index'],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?= Alert::widget() ?>

        <?= $content ?>
    </div>
</div>
<footer class="footer footer-inverse bg-inverse py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4 text-center">
                <div class="copyright">
                    © <?= Yii::$app->name ?> 2017 - <?= date('Y') ?>
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
