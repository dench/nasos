<?php

use app\models\Feature;
use app\models\Value;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $page \app\models\Category */

$features = Feature::getFilterList(true, [$model->category_id]);
?>

<?php if (count($features)) : ?>
    <?php
    $js = <<<JS
$('input[type="checkbox"]').change(function(){
    $(this).parents('form').submit();
});
JS;
    $this->registerJs($js);
    ?>
    <div class="product-search">

        <?php $form = ActiveForm::begin([
            'action' => Url::current(),
            'method' => 'get',
            'options' => [
                'class' => 'row',
                'data-pjax' => true,
            ],
        ]); ?>

        <?php foreach ($features as $key => $feature) : ?>
            <div class="col-sm-4 col-md-3">
                <?= $form->field($model, 'feature_ids[' . $feature->id . ']')->checkboxList(Value::getList($feature->id))->label($feature->name . ($feature->after ? ', ' . $feature->after : '')) ?>
            </div>
        <?php endforeach; ?>

        <?php ActiveForm::end(); ?>

    </div>
<?php endif; ?>