<?php

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $viewed app\models\Product[] */

echo $this->render('_breadcrumbs', [
    'model' => $model,
]);

?>
<div class="container page product">
    <h1 class="page-title"><?= $model->h1 ?></h1>
    <div class="row">
        <div class="col-sm-5">
            <?= $this->render('_photo', [
                'model' => $model,
            ]) ?>
            <?= $this->render('_price', [
                'model' => $model,
            ]) ?>
        </div>
        <div class="col-sm-7">
            <?= $this->render('_feature', [
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

<?= $this->render('_viewed', [
    'viewed' => $viewed,
]) ?>