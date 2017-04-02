<?php

use app\models\Brand;
use app\models\Category;
use app\models\Complect;
use app\models\Product;
use app\models\ProductStatus;
use dench\language\models\Language;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */

$js = '';

foreach (Language::suffixList() as $suffix => $name) {

    $js .= "
var name" . $suffix . " = '';
$('#product-name" . $suffix . "').focus(function(){
    name" . $suffix . " = $(this).val();
}).blur(function(){
    var h1 = $('#product-h1" . $suffix . "');
    if (h1.val() == name" . $suffix . ") {
        h1.val($(this).val());
    }
    var title = $('#product-title" . $suffix . "');
    if (title.val() == name" . $suffix . ") {
        title.val($(this).val());
    }
});";

}

$this->registerJs($js);
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <ul class="nav nav-tabs">
        <?php foreach (Language::suffixList() as $suffix => $name) : ?>
            <li class="nav-item<?= empty($suffix) ? ' active': '' ?>"><a href="#lang<?= $suffix ?>-tab" class="nav-link" data-toggle="tab"><?= $name ?></a></li>
        <?php endforeach; ?>
        <li class="nav-item"><a href="#main-tab" class="nav-link" data-toggle="tab"><?= Yii::t('app', 'Main') ?></a></li>
        <li class="nav-item"><a href="#complects-tab" class="nav-link" data-toggle="tab"><?= Yii::t('app', 'Complectation') ?></a></li>
        <li class="nav-item"><a href="#options-tab" class="nav-link" data-toggle="tab"><?= Yii::t('app', 'Additional options') ?></a></li>
    </ul>

    <div class="tab-content">
        <?php foreach (Language::suffixList() as $suffix => $name) : ?>
            <div class="tab-pane fade<?php if (empty($suffix)) echo ' in active'; ?>" id="lang<?= $suffix ?>-tab">
                <?= $form->field($model, 'name' . $suffix)->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'h1' . $suffix)->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'title' . $suffix)->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'keywords' . $suffix)->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'description' . $suffix)->textarea() ?>
                <?= $form->field($model, 'text' . $suffix)->widget(CKEditor::className(), [
                    'preset' => 'full',
                    'clientOptions' => [
                        'customConfig' => '/js/ckeditor.js',
                        'language' => Yii::$app->language,
                        'allowedContent' => true,
                    ]
                ]) ?>
            </div>
        <?php endforeach; ?>

        <div class="tab-pane fade" id="main-tab">
            <?= $form->field($model, 'category_ids')->dropDownList(Category::getList(null), [
                'multiple' => true,
                'size' => 10,
            ]) ?>

            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'brand_id')->dropDownList(Brand::getList(true), ['prompt' => '']) ?>

            <?= $form->field($model, 'status_id')->dropDownList(ProductStatus::getList(), ['prompt' => '']) ?>

            <?= $form->field($model, 'view')->dropDownList(['container' => 'container', 'accessory' => 'accessory'], ['prompt' => '']) ?>

            <?= $form->field($model, 'price_from')->checkbox() ?>

            <?= $form->field($model, 'enabled')->checkbox() ?>
        </div>

        <div class="tab-pane fade" id="complects-tab">
            <?= $form->field($model, 'complect_ids')->dropDownList(Complect::getList(), [
                'multiple' => true,
                'size' => 30,
            ]) ?>
        </div>

        <div class="tab-pane fade" id="options-tab">
            <?= $form->field($model, 'option_ids')->dropDownList(Product::getList(null), [
                'multiple' => true,
                'size' => 30,
                'options' => [
                    $model->id => [
                        'disabled' => true,
                    ]
                ]
            ]) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
