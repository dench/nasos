<?php

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $similar app\models\Product[] */
/* @var $viewed boolean */

echo $this->render('_breadcrumbs', [
    'model' => $model,
]);

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