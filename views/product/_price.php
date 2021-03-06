<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.04.17
 * Time: 22:59
 *
 * @var $model dench\products\models\Product
 */

use yii\bootstrap\Modal;
use yii\bootstrap\Html;
use yii\helpers\Url;

$url_add = Url::to(['/cart/add']);
$url_modal = Url::to(['/cart/modal']);

$js = <<<JS
$('.btn-buy').mousedown(function(){
    var id = $(this).attr('rel');
    $.get('{$url_add}', { id: id }, function(){
        openModal('{$url_modal}');
    });
});
JS;

if (empty($model->variants[0]->price)) {
    $js .= <<< JS
$('.modal-callback-open').mousedown(function(){
    $('#modal-callback').modal('show').find('#modal-callback-content').load($(this).attr('data-target'));
});
JS;
    Modal::begin([
        'id' => 'modal-callback',
        'header' => '<h3>' . Yii::t('app', 'Callback') . '</h3>',
    ]);
    echo Html::tag('div', '', ['id' => 'modal-callback-content']);
    Modal::end();
}

$this->registerJs($js);
?>
<div class="row">
<?php if (@$model->variants[0]->price): ?>
    <?php if (count($model->variants) > 1): ?>
        <div class="col-sm-12">
            <table class="table table-striped table-hover table-condensed table-default">
                <thead>
                <tr>
                    <th><?= Yii::t('app', 'Model') ?></th>
                    <th><?= Yii::t('app', 'Price, UAH') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($model->variants as $variant) : ?>
                    <tr>
                        <th>
                            <?= $variant->name ?>
                        </th>
                        <td>
                            <?= ($model->price_from) ? Yii::t('app', 'from') : "" ?>
                            <?= $variant->price ?>
                        </td>
                        <td>
                            <button class="btn btn-primary btn-block btn-buy btn-sm" rel="<?= $variant->id ?>"><?= Yii::t('app', 'Buy') ?></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-sm-12">
    <?php else: ?>
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
            <button class="btn btn-primary btn-block btn-buy btn-lg" rel="<?= $model->variants[0]->id ?>"><?= Yii::t('app', 'Buy') ?></button>
        </div>
        <div class="col-sm-6">
    <?php endif; ?>
<?php else: ?>
    <div class="col-sm-6">
        <button class="btn btn-primary btn-block btn-lg modal-callback-open" data-target="<?= Url::to(['/site/callback']) ?>"><?= Yii::t('app', 'To order') ?></button>
    </div>
    <div class="col-sm-6">
<?php endif; ?>
        <div class="product-buy">
            <small class="text-muted"><?= Yii::t('app', 'You can order by phone') ?></small>
            <div class="phone"><?= Yii::$app->params['phone1'] ?></div>
            <div class="phone"><?= Yii::$app->params['phone2'] ?></div>
        </div>
    </div>
</div>