<?php

use app\helpers\ImageHelper;
use app\models\Category;
use dench\language\models\Language;
use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */

$js = '';

foreach (Language::suffixList() as $suffix => $name) {

    $js .= "
var name" . $suffix . " = '';
$('#category-name" . $suffix . "').focus(function(){
    name" . $suffix . " = $(this).val();
}).blur(function(){
    var h1 = $('#category-h1" . $suffix . "');
    if (h1.val() == name" . $suffix . ") {
        h1.val($(this).val());
    }
    var title = $('#category-title" . $suffix . "');
    if (title.val() == name" . $suffix . ") {
        title.val($(this).val());
    }
});";

}

$this->registerJs($js);
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <ul class="nav nav-tabs">
        <?php foreach (Language::suffixList() as $suffix => $name) : ?>
            <li class="nav-item<?= empty($suffix) ? ' active': '' ?>"><a href="#lang<?= $suffix ?>" class="nav-link" data-toggle="tab"><?= $name ?></a></li>
        <?php endforeach; ?>
    </ul>

    <div class="tab-content">
        <?= $form->field($model, 'parent_id')
            ->dropDownList(Category::getList(true), [
                'prompt' => '',
                'options' => [
                    $model->id => [
                        'disabled' => true,
                    ],
                ],
        ]) ?>

        <?php foreach (Language::suffixList() as $suffix => $name) : ?>
            <div class="tab-pane fade<?php if (empty($suffix)) echo ' in active'; ?>" id="lang<?= $suffix ?>">
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

        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'image_id')->textInput() ?>

        <?= $form->field($model, 'position')->textInput() ?>

        <?= $form->field($model, 'enabled')->checkbox() ?>

        <?= $form->field($model, 'main')->checkbox() ?>

        <?php
        $fileInputName = 'files';
        $modelInputName = $model->formName() . '[image_id]';
        $initialPreview = [];
        $initialPreviewConfig = [];
        if (isset($image->id)) {
            $initialPreview[] = '<img src="' . ImageHelper::size($image->id, 'small') . '" alt="" width="100%"><input type="hidden" name="' . $modelInputName . '" value="' . $image->id . '">';
            $initialPreviewConfig[] = [
                'url' => Url::to(['/admin/ajax/file-hide']),
                'key' => $image->file_id,
            ];
        }
        echo FileInput::widget([
            'id' => $fileInputName,
            'name' => $fileInputName,
            'options' => [
                'multiple' => false,
                'accept' => 'image/jpeg'
            ],
            'language' => Yii::$app->language,
            'pluginOptions' => [
                'initialPreview' => $initialPreview,
                'initialPreviewConfig' => $initialPreviewConfig,
                'fileActionSettings' => [
                    'showZoom' => false,
                    'dragClass' => 'btn btn-xs btn-default',
                ],
                'previewFileType' => 'image',
                'uploadUrl' => Url::to(['/admin/ajax/file-upload']),
                'uploadExtraData' => [
                    'name' => $modelInputName,
                ],
                'uploadAsync' => false,
                'showUpload' => false,
                'showRemove' => false,
                'showBrowse' => true,
                'showCaption' => false,
                'showClose' => false,
                'showPreview ' => false,
                'dropZoneEnabled' => false,
                'layoutTemplates' => [
                    'modalMain' => '',
                    'modal' => '',
                    'footer' => '<div class="file-thumbnail-footer">{actions}</div>',
                    'actions' => '{delete}',
                    'progress' => '',
                ],
                'previewTemplates' => [
                    'generic' => '
<div class="col-sm-4 file-sortable">
    <div class="file-preview-frame kv-preview-thumb file-drag-handle drag-handle-init" id="{previewId}" data-fileindex="{fileindex}" data-template="{template}">
    <div class="kv-file-content">
        {content}
    </div>
    {footer}
    </div>
    </div>',
                    'image' => '
    <div class="col-sm-4">
    <div class="file-preview-frame kv-preview-thumb" id="{previewId}" data-fileindex="{fileindex}" data-template="{template}">
    <div class="kv-file-content">
        <img src="{data}" class="kv-preview-data file-preview-image" title="{caption}" alt="{caption}" width="100%">
    </div>
    {footer}
    </div>
</div>',
                ],
            ],
            'pluginEvents' => [
                'filebatchselected' => 'function(event, files) { $("#' . $fileInputName . '").fileinput("upload"); }',
            ],
        ]);
        ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
