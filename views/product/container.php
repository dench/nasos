<?php

/* @var $this yii\web\View */
/* @var $model dench\products\models\Product */
/* @var $similar dench\products\models\Product[] */
/* @var $viewed boolean */

use yii\bootstrap\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

echo $this->render('_breadcrumbs', [
    'model' => $model,
]);

$js = <<< JS
$('.modal-callback-open').mousedown(function(){
    $('#modal-callback').modal('show').find('#modal-callback-content').load($(this).attr('data-target'));
});
JS;
Modal::begin([
    'id' => 'modal-callback',
    'header' => '<h3>' . Yii::t('app', 'Callback') . '</h3>',
]);
echo Html::tag('div', '', ['id' => 'modal-callback-content']);
Modal::end();

$this->registerJs($js);
?>
<div class="container page product">
    <h1 class="page-title"><?= $model->h1 ?></h1>
    <div class="row">
        <div class="col-md-5">
            <?= $this->render('_photo', [
                'model' => $model,
            ]) ?>
        </div>
        <div class="col-md-7">
            <button class="btn btn-primary btn-lg modal-callback-open" data-target="<?= Url::to(['/site/callback']) ?>"><?= Yii::t('app', 'To order') ?></button>
            <br>
            <?= $this->render('_feature_simple', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

    <?= $this->render('_text', [
        'name' => $model->name,
        'text' => $model->text,
    ]) ?>

    <?= $this->render('_complects', [
        'complects' => $model->complects,
    ]) ?>

    <?= $this->render('_options', [
        'options' => $model->options,
    ]) ?>
    
</div>

<?= $this->render('_similar', [
    'viewed' => $viewed,
    'similar' => $similar,
]) ?>