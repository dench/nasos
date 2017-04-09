<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.04.17
 * Time: 22:52
 *
 * @var $model app\models\Product
 */

use app\assets\PhotoSwipe;
use dench\image\helpers\ImageHelper;

PhotoSwipe::register($this);
Yii::$app->view->registerJsFile('@web/js/photoswipe.js', ['depends' => 'app\assets\PhotoSwipe']);
$script = <<< JS
    initPhotoSwipeFromDOM('.product-photo');
JS;
Yii::$app->view->registerJs($script, yii\web\View::POS_READY);

?>
<div class="product-photo">
    <?php if ($model->image) { ?>
        <a href="<?= ImageHelper::thumb($model->image->id, 'big') ?>" class="thumbnail" data-size="<?= $model->image->width ?>x<?= $model->image->height ?>">
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
    photo.find('a').attr('href', thumb.attr('href')).find('img').attr('src', thumb.find('img').attr('src'));
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
                <a href="<?= ImageHelper::thumb($image->id, 'big') ?>" class="thumbnail<?php if ($model->image->id == $image->id) echo " active"; ?>" data-size="<?= $image->width ?>x<?= $image->height ?>">
                    <img src="<?= ImageHelper::thumb($image->id, 'cover') ?>" alt="<?= $model->name ?>">
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>
            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>
            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>