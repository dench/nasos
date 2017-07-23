<?php

use app\models\Brand;
use app\models\Category;
use app\models\Complect;
use app\models\Product;
use app\models\Status;
use app\models\Value;
use dench\image\widgets\ImageUpload;
use dench\language\models\Language;
use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $modelsVariant app\models\Variant[] */
/* @var $variantImages dench\image\models\Image[] */
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

$js .= "
$('.variantsWrapper').on('afterInsert', function(e, item) {
    var iD = $(this).find('input:last').attr('id');
    var key = iD.split('-');
    //console.log(key[1]);
    reloadPjax();
});
$('.variantsWrapper').on('afterDelete', function(e, item) {
    reloadPjax();
});
$('.variantsWrapper').on('beforeDelete', function(e, item) {
    //var iD = $(this).find('input:last').attr('id');
    //var key = iD.split('-');
    //console.log(key[1]);
    var iD = item.firstElementChild.value;
    $('.i' + iD).parents('.variant-images').remove();
});
function reloadPjax() {
    $.pjax.reload({
        container: '#images-pjax', 
        timeout: 2000,
        url: '',
        type: 'POST',
        data: $('#product-form').serialize()
    });
}
";

$this->registerJs($js);
?>

<div class="product-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
        'validateOnChange' => true,
        'validateOnBlur' => false,
        'options' => [
            'enctype' => 'multipart/form-data',
            'id' => 'product-form',
        ]
    ]); ?>

    <ul class="nav nav-tabs">
        <?php foreach (Language::suffixList() as $suffix => $name) : ?>
            <li class="nav-item<?= empty($suffix) ? ' active': '' ?>"><a href="#lang<?= $suffix ?>-tab" class="nav-link" data-toggle="tab"><?= $name ?></a></li>
        <?php endforeach; ?>
        <li class="nav-item"><a href="#main-tab" class="nav-link" data-toggle="tab"><?= Yii::t('app', 'Main') ?></a></li>
        <li class="nav-item"><a href="#complects-tab" class="nav-link" data-toggle="tab"><?= Yii::t('app', 'Complectation') ?></a></li>
        <li class="nav-item"><a href="#options-tab" class="nav-link" data-toggle="tab"><?= Yii::t('app', 'Additional options') ?></a></li>
        <li class="nav-item"><a href="#variant-tab" class="nav-link" data-toggle="tab"><?= Yii::t('app', 'Price') ?></a></li>
        <li class="nav-item"><a href="#images-tab" class="nav-link" data-toggle="tab"><?= Yii::t('app', 'Images') ?></a></li>
        <li class="nav-item"><a href="#feature-tab" class="nav-link" data-toggle="tab"><?= Yii::t('app', 'Features') ?></a></li>
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

            <?= $form->field($model, 'status_ids')->checkboxList(Status::getList(null)) ?>

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

        <div class="tab-pane fade" id="variant-tab">
            <?php

            $formFields = [
                'price',
                'price_old',
                'currency_id',
                'code',
                'available',
                'unit_id',
                'enabled',

                'image_ids',
                'files',
            ];

            foreach (Language::suffixList() as $suffix => $name) {
                $formFields[] = 'name' . $suffix;
            }

            DynamicFormWidget::begin([
                'widgetContainer' => 'variantsWrapper',
                'widgetBody' => '.variant-items',
                'widgetItem' => '.variant-item',
                'limit' => 99,
                'min' => 1,
                'insertButton' => '.add-variant',
                'deleteButton' => '.remove-variant',
                'model' => current($modelsVariant),
                'formId' => 'product-form',
                'formFields' => $formFields,
            ]); ?>

            <div class="variant-items">
                <?php foreach ($modelsVariant as $index => $modelVariant) : ?>
                    <div class="well variant-item" data-position="<?= $modelVariant->position ?>" data-key="<?= $modelVariant->id ?>">
                        <?= $this->render('_form_variant', [
                            'form' => $form,
                            'modelVariant' => $modelVariant,
                            'index' => $index,
                        ]) ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="form-group text-right">
                <?= Html::button(Yii::t('app', 'Add variant'), ['class' => 'btn btn-default add-variant']) ?>
            </div>

            <?php DynamicFormWidget::end(); ?>
        </div>

        <div class="tab-pane fade" id="images-tab">
            <div class="variants-images">
                <?php Pjax::begin(['id' => 'images-pjax']); ?>
                <?php foreach ($variantImages as $index => $images) : ?>
                    <div class="well variant-images">
                        <?= ImageUpload::widget([
                            'images' => $images,
                            'image_id' => $modelsVariant[$index]->image_id,
                            'imageEnabled' => $modelsVariant[$index]->imageEnabled,
                            'col' => 'col-sm-4 col-md-3 i' . $modelsVariant[$index]->id,
                            'size' => 'fill',
                            'modelInputName' => 'Variant[' . $index . ']',
                            'fileInputName' => 'files' . $index,
                            'label' => null,
                        ]) ?>
                    </div>
                <?php endforeach; ?>
                <?php Pjax::end(); ?>
            </div>
        </div>

        <div class="tab-pane fade" id="feature-tab">
                <?php if (empty($features)) : ?>
                    <?= Html::tag('div', Yii::t('app', 'Choose a product!'), ['class' => 'alert alert-danger']) ?>
                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th><?= Yii::t('app', 'Name') ?></th>
                                <?php foreach ($modelsVariant as $index => $modelVariant) : ?>
                                    <td><?= $modelVariant->name ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <?php foreach ($features as $feature) : ?>
                                <tr>
                                    <td><?= $feature->name . ($feature->after ? ', ' . $feature->after : '') ?></td>
                                    <?php foreach ($modelsVariant as $index => $modelVariant) : ?>
                                        <td>
                                            <?= Select2::widget([
                                                'name' => 'Variant[' . $index . '][value_ids][]',
                                                'data' => Value::getList($feature->id),
                                                'value' => $modelVariant->value_ids,
                                                'size' => Select2::SMALL,
                                                'options' => ['placeholder' => Yii::t('app', 'Select'), 'multiple' => true],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                                'showToggleAll' => false,
                                            ]) ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-lg btn-success' : 'btn btn-lg btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
