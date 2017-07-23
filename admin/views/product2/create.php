<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $modelsVariant app\models\Variant[] */
/* @var $variantImages \dench\image\models\Image[] */
/* @var $features \app\models\Feature[] */

$this->title = Yii::t('app', 'Create Product');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsVariant' => $modelsVariant,
        'variantImages' => $variantImages,
        'features' => $features,
    ]) ?>

</div>
