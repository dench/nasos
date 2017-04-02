<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.04.17
 * Time: 22:09
 *
 * @var $text string
 * @var $name string
 */
?>
<?php if ($text) : ?>
    <div class="product-section">
        <h2 class="product-section-title"><span class="line"><?= $name ?></span></h2>
        <?= $text ?>
    </div>
<?php endif; ?>
