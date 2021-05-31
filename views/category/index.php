<?php
/* @var $this yii\web\View */
/* @var $page dench\page\models\Page */
/* @var $categories dench\products\models\Category[] */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\bootstrap\Html;
use yii\bootstrap\Modal;
use yii\widgets\ListView;

$this->params['breadcrumbs'][] = $page->name;
?>
<div class="container page">

    <h1 class="page-title"><?= $page->h1 ?></h1>

    <?php if ($page->short) : ?>
    <div class="page-text">
        <?= $page->short ?>
    </div>
    <?php endif; ?>

    <?= Yii::$app->cache->getOrSet('_categories-' . Yii::$app->language, function () use ($categories) {
            return $this->render('_categories', [
                'categories' => $categories,
            ]);
        });
    ?>

    <h2 class="page-title" style="margin-top: 30px"><?= Yii::t('app', 'Our production') ?></h2>

    <?php
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
        'layout' => "<div class=\"row\">{items}</div>\n<div class=\"clear-pager text-center\">{pager}</div>",
        'emptyTextOptions' => [
            'class' => 'alert alert-danger',
        ],
        'itemOptions' => [
            'tag' => null,
        ],
    ]);
    ?>

    <?php if ($page->text) : ?>
        <div class="page-seo">
            <?= $page->text ?>
        </div>
    <?php endif; ?>
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