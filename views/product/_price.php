<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.04.17
 * Time: 22:59
 *
 * @var $model app\models\Product
 */
?>
<div class="row">
<?php if ($model->variants[0]->price) { ?>
    <?php if (count($model->variants) > 1) { ?>
        <div class="col-sm-12">
            <table class="table table-striped table-hover table-condensed table-default">
                <thead>
                <tr>
                    <th><?= Yii::t('app', 'Model') ?></th>
                    <th><?= Yii::t('app', 'Price, UAH') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($model->variants as $variant) : ?>
                    <tr>
                        <th><?= $variant->name ?></th>
                        <td><?= $variant->price ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-sm-12">
    <?php } else { ?>
        <div class="col-sm-6">
            <?php if ($model->variants[0]->code) : ?>
                <div class="product-code">
                    <div class="title"><?= Yii::t('app', 'Vendor code') ?>:</div>
                    <div><?= $model->variants[0]->code ?></div>
                </div>
            <?php endif; ?>
            <div class="product-price">
                <div class="title"><?= Yii::t('app', 'Price') ?>:</div>
                <div>
                    <?php if ($model->price_from) : ?>
                        <?= Yii::t('app', 'from') ?>
                    <?php endif; ?>
                    <?= $model->variants[0]->currency->before ?>
                    <?= $model->variants[0]->price ?>
                    <?= $model->variants[0]->currency->after ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
    <?php } ?>
<?php } else {?>
    <div class="col-sm-12">
<?php } ?>
        <div class="product-buy">
            <small class="text-muted"><?= Yii::t('app', 'You can order by phone') ?></small>
            <div class="phone"><?= Yii::$app->params['phone'] ?></div>
        </div>
    </div>
</div>