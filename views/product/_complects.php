<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.04.17
 * Time: 22:08
 *
 * @var $complects app\models\Complect[]
 */
?>
<?php if ($complects) : ?>
    <div class="product-section">
        <h2 class="product-section-title"><span class="line"><?= Yii::t('app', 'Complectation') ?></span></h2>
        <ul>
            <?php foreach ($complects as $complect) : ?>
                <li><?= $complect->name ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
