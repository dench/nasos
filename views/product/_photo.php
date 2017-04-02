<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.04.17
 * Time: 22:52
 *
 * @var $model app\models\Product
 */

use dench\image\helpers\ImageHelper;

?>
<div class="product-photo">
    <?php if ($model->image) { ?>
        <a href="<?= ImageHelper::thumb($model->image->id, 'big') ?>" class="thumbnail">
            <img src="<?= ImageHelper::thumb($model->image->id, 'cover') ?>" alt="<?= $model->name ?>">
        </a>
    <?php } else { ?>
        <div class="thumbnail">
            <img src="/img/photo-default.png" alt="photo-default">
        </div>
    <?php } ?>
</div>
<?php
$images = [];
foreach ($model->variants as $variant) {
    foreach ($variant->images as $image) {
        $images[] = $image;
    }
}
if (count($images) > 1) {
    $js = <<<JS
$('.product-photos a').click(function(e){
    $('.product-photos a').removeClass('active');
    var photo = $('.product-photo');
    var thumb = $(this);
    photo.find('a').attr('href', thumb.find('a').attr('href')).find('img').attr('src', thumb.find('img').attr('src'));
    $(this).addClass('active');
    e.preventDefault();
});
JS;
    $this->registerJs($js);
}
?>
<?php if (count($images) > 1) : ?>
    <div class="row product-photos">
        <?php foreach ($images as $image) : ?>
            <div class="col-xs-4 col-sm-3 col-md-4">
                <a href="<?= ImageHelper::thumb($image->id, 'big') ?>" class="thumbnail<?php if ($model->image->id == $image->id) echo " active"; ?>">
                    <img src="<?= ImageHelper::thumb($image->id, 'cover') ?>" alt="<?= $model->name ?>">
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>