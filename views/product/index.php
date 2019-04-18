<?php

/* @var $this yii\web\View */
/* @var $model dench\products\models\Product */
/* @var $similar dench\products\models\Product[] */
/* @var $viewed boolean */


echo $this->render('_breadcrumbs', [
    'model' => $model,
]);

$this->registerJsFile('//ppcalc.privatbank.ua/pp_calculator/resources/js/calculator.js');

$js = <<<JS
var resCalc = PP_CALCULATOR.calculatePhys(1, 500);
resCalc = {payCount: 2, ipValue: "264.50", ipaValue: "254.95", ppValue: "250.00"}
console.log(resCalc.payCount);
JS;

$this->registerJs($js);
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

<?= $this->render('_similar', [
    'viewed' => $viewed,
    'similar' => $similar,
]) ?>