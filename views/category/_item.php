<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 25.03.17
 * Time: 13:24
 *
 * @var \app\models\Product $model
 */

use app\widgets\ProductCard;

echo Yii::$app->cache->getOrSet('_product_card-' . $model->id . '-' . Yii::$app->language, function () use ($model) {
    return ProductCard::widget([
        'model' => $model,
        'link' => ['product/index', 'slug' => $model->slug],
    ]);
});