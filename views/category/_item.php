<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 25.03.17
 * Time: 13:24
 *
 * @var \dench\products\models\Product $model
 * @var int $index
 */

use app\widgets\ProductCard;

if ($index % 4 === 0) {
    echo '<div class="clearfix visible-md-block visible-lg-block"></div>';
}
if ($index % 3 === 0) {
    echo '<div class="clearfix visible-sm-block"></div>';
}
if ($index % 2 === 0) {
    echo '<div class="clearfix visible-xs-block"></div>';
}

echo Yii::$app->cache->getOrSet('_product_card-' . $model->id . '-' . Yii::$app->language, function () use ($model) {
    return ProductCard::widget([
        'model' => $model,
        'link' => ['product/index', 'slug' => $model->slug],
    ]);
});