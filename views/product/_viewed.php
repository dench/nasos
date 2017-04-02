<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.04.17
 * Time: 22:03
 *
 * @var $viewed app\models\Product[]
 */

use dench\image\helpers\ImageHelper;
use yii\helpers\Url;

?>
<?php if ($viewed) : ?>
    <section class="section section-viewed bg-grey">
        <div class="container">
            <h3><?= Yii::t('app', 'You looked through') ?></h3>
            <div class="row">
                <?php foreach ($viewed as $product) : ?>
                    <div class="col-xs-6 col-sm-3 col-md-3 col-lg-2">
                        <div class="card block-link">
                            <div class="card-img">
                                <?php if ($product->image) { ?>
                                    <img src="<?= ImageHelper::thumb($product->image->id, 'cover') ?>" class="img-responsive" alt="<?= $product->name ?>">
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
<?php endif; ?>