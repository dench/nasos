<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.04.17
 * Time: 23:11
 *
 * @var $this yii\web\View
 * @var $model app\models\Product
 */

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Products'),
    'url' => ['category/index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $model->categories[0]->name,
    'url' => ['category/view', 'slug' => $model->categories[0]->slug],
];
$this->params['breadcrumbs'][] = $model->name;
