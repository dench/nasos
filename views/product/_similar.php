<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.04.17
 * Time: 22:03
 *
 * @var $similar app\models\Product[]
 * @var $viewed boolean
 */

use dench\image\helpers\ImageHelper;
use yii\helpers\Url;

?>
<section class="section section-viewed bg-grey">
    <div class="container">
        <?php if ($viewed): ?>
            <h3><?= Yii::t('app', 'You looked through') ?></h3>
        <?php else: ?>
            <h3><?= Yii::t('app', 'Similar products') ?></h3>
        <?php endif; ?>
        <div class="row">
            <?php foreach ($similar as $product) : ?>
                <div class="<?php

                $count = count($similar);

                echo "col-xxs-6";

                echo " col-xs-4";

                if ($count == 4) {
                    echo " col-sm-3";
                } else {
                    echo " col-sm-4";
                }

                if ($count <= 4) {
                    echo " col-md-3";
                } else {
                    echo " col-md-2";
                }

                echo " col-lg-2";

                ?>">
                    <div class="card block-link">
                        <div class="card-img">
                            <?php if ($product->image) { ?>
                                <img src="<?= ImageHelper::thumb($product->image->id, 'micro') ?>" class="img-responsive" alt="<?= $product->image->alt ? $product->image->alt : $product->name ?>" title="<?= $product->title ?>">
                            <?php } else { ?>
                                <img src="<?= Yii::$app->params['image']['none'] ?>" class="img-responsive" alt="">
                            <?php } ?>
                        </div>
                        <div class="card-block">
                            <h5 class="card-title">
                                <a href="<?= Url::to(['product/index', 'slug' => $product->slug]) ?>"><?= $product->name ?></a>
                            </h5>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>